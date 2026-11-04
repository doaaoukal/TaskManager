
package main

import (
	"encoding/json"
	"log"
	"net/http"
	"strconv"
	"strings"
	"sync"
)

type Task struct {
	ID    int    `json:"id"`
	Title string `json:"title"`
}

var (
	tasks = []Task{
		{ID: 1, Title: "Learn Go REST API"},
		{ID: 2, Title: "Connect Laravel to Go"},
	}

	nextID = 3
	mu     sync.Mutex
)

func tasksHandler(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")

	switch r.Method {
	case http.MethodGet:
		mu.Lock()
		defer mu.Unlock()
		json.NewEncoder(w).Encode(tasks)

	case http.MethodPost:
		var input Task

		if err := json.NewDecoder(r.Body).Decode(&input); err != nil {
			http.Error(w, `{"error":"Invalid JSON"}`, http.StatusBadRequest)
			return
		}

		if strings.TrimSpace(input.Title) == "" {
			http.Error(w, `{"error":"Title is required"}`, http.StatusBadRequest)
			return
		}

		mu.Lock()
		input.ID = nextID
		nextID++
		tasks = append(tasks, input)
		mu.Unlock()

		w.WriteHeader(http.StatusCreated)
		json.NewEncoder(w).Encode(input)

	default:
		w.Header().Set("Allow", "GET, POST")
		http.Error(w, `{"error":"Method not allowed"}`, http.StatusMethodNotAllowed)
	}
}

func taskItemHandler(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")

	idText := strings.TrimPrefix(r.URL.Path, "/tasks/")
	id, err := strconv.Atoi(idText)

	if err != nil || id <= 0 {
		http.Error(w, `{"error":"Invalid task ID"}`, http.StatusBadRequest)
		return
	}

	switch r.Method {
	case http.MethodPut:
		var input Task

		if err := json.NewDecoder(r.Body).Decode(&input); err != nil {
			http.Error(w, `{"error":"Invalid JSON"}`, http.StatusBadRequest)
			return
		}

		if strings.TrimSpace(input.Title) == "" {
			http.Error(w, `{"error":"Title is required"}`, http.StatusBadRequest)
			return
		}

		mu.Lock()
		defer mu.Unlock()

		for i := range tasks {
			if tasks[i].ID == id {
				tasks[i].Title = strings.TrimSpace(input.Title)
				json.NewEncoder(w).Encode(tasks[i])
				return
			}
		}

		http.Error(w, `{"error":"Task not found"}`, http.StatusNotFound)

	case http.MethodDelete:
		mu.Lock()
		defer mu.Unlock()

		for i, task := range tasks {
			if task.ID == id {
				tasks = append(tasks[:i], tasks[i+1:]...)
				json.NewEncoder(w).Encode(map[string]string{
					"message": "Task deleted successfully",
				})
				return
			}
		}

		http.Error(w, `{"error":"Task not found"}`, http.StatusNotFound)

	default:
		w.Header().Set("Allow", "PUT, DELETE")
		http.Error(w, `{"error":"Method not allowed"}`, http.StatusMethodNotAllowed)
	}
}

// Health check endpoint
func healthHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodGet {
		w.Header().Set("Allow", "GET")
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(http.StatusOK)

	json.NewEncoder(w).Encode(map[string]string{
		"status": "healthy",
	})
}

func main() {
	http.HandleFunc("/tasks", tasksHandler)
	http.HandleFunc("/tasks/", taskItemHandler)
	http.HandleFunc("/health", healthHandler)

	log.Println("Go API running at http://localhost:8081")
	log.Fatal(http.ListenAndServe(":8081", nil))
}
