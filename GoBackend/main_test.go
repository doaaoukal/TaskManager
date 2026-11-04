
package main

import (
	"encoding/json"
	"net/http"
	"net/http/httptest"
	"testing"
)

func TestHealthHandler(t *testing.T) {
	req := httptest.NewRequest(http.MethodGet, "/health", nil)
	rec := httptest.NewRecorder()

	healthHandler(rec, req)

	if rec.Code != http.StatusOK {
		t.Fatalf("Expected status %d, got %d",
			http.StatusOK, rec.Code)
	}

	var response map[string]string

	if err := json.Unmarshal(rec.Body.Bytes(), &response); err != nil {
		t.Fatalf("Invalid JSON response: %v", err)
	}

	if response["status"] != "healthy" {
		t.Errorf("Expected healthy, got %q", response["status"])
	}
}

func TestHealthHandlerMethodNotAllowed(t *testing.T) {
	req := httptest.NewRequest(http.MethodPost, "/health", nil)
	rec := httptest.NewRecorder()

	healthHandler(rec, req)

	if rec.Code != http.StatusMethodNotAllowed {
		t.Errorf("Expected status %d, got %d",
			http.StatusMethodNotAllowed, rec.Code)
	}
}
