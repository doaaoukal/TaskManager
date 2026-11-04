
<?php
use Livewire\Component;
use Illuminate\Support\Facades\Http;

new class extends Component
{
    public $tasks = [];
    public $title = '';
    public $editIndex = null;
    public $editTitle = '';
    public $errorMessage = '';

    private function apiUrl()
    {
        return rtrim(config('services.go_api.url'), '/') . '/tasks';
    }

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        try {
            $response = Http::get($this->apiUrl());

            if ($response->successful()) {
                $this->tasks = $response->json() ?? [];
                $this->errorMessage = '';
            } else {
                $this->errorMessage = 'Could not load tasks from Go API.';
            }
        } catch (\Throwable $e) {
            $this->errorMessage = 'Cannot connect to Go API. Make sure Go is running.';
        }
    }

    public function addTask()
    {
        $taskTitle = trim($this->title);

        if ($taskTitle === '') {
            return;
        }

        try {
            $response = Http::post($this->apiUrl(), [
                'title' => $taskTitle,
            ]);

            if ($response->successful()) {
                $this->title = '';
                $this->loadTasks();
            } else {
                $this->errorMessage = 'Could not add the task.';
            }
        } catch (\Throwable $e) {
            $this->errorMessage = 'Cannot connect to Go API.';
        }
    }

    public function editTask($id)
    {
        foreach ($this->tasks as $index => $task) {
            if ((int) $task['id'] === (int) $id) {
                $this->editIndex = $index;
                $this->editTitle = $task['title'];
                $this->errorMessage = '';
                return;
            }
        }
    }

    public function updateTask()
    {
        if (
            $this->editIndex === null ||
            !isset($this->tasks[$this->editIndex]) ||
            trim($this->editTitle) === ''
        ) {
            return;
        }

        $id = $this->tasks[$this->editIndex]['id'];

        try {
            $response = Http::put(
                $this->apiUrl() . '/' . $id,
                ['title' => trim($this->editTitle)]
            );

            if ($response->successful()) {
                $this->editIndex = null;
                $this->editTitle = '';
                $this->loadTasks();
            } else {
                $this->errorMessage =
                    'Update failed. Check PUT support in Go API.';
            }
        } catch (\Throwable $e) {
            $this->errorMessage = 'Cannot connect to Go API.';
        }
    }

    public function cancelEdit()
    {
        $this->editIndex = null;
        $this->editTitle = '';
    }

    public function deleteTask($id)
    {
        try {
            $response = Http::delete($this->apiUrl() . '/' . $id);

            if ($response->successful()) {
                $this->cancelEdit();
                $this->loadTasks();
            } else {
                $this->errorMessage = 'Could not delete the task.';
            }
        } catch (\Throwable $e) {
            $this->errorMessage = 'Cannot connect to Go API.';
        }
    }
};
?>

<div style="max-width: 700px; margin: 0 auto; padding: 24px; font-family: Arial, sans-serif;">

    <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 20px;">
        Task Manager
    </h1>

    @if ($errorMessage)
        <div style="color: #b91c1c; border: 1px solid #fca5a5; padding: 12px; margin-bottom: 16px; border-radius: 6px;">
            {{ $errorMessage }}
        </div>
    @endif

    <form wire:submit="addTask"
          style="display: flex; gap: 8px; margin-bottom: 16px;">

        <input
            type="text"
            wire:model="title"
            placeholder="Enter a task..."
            style="flex: 1; min-width: 0; padding: 12px; border: 1px solid #999; border-radius: 5px;"
        >

        <button
            type="submit"
            style="display: inline-block; background: #2563eb; color: white; padding: 12px 18px; border: 0; border-radius: 5px; cursor: pointer;"
        >
            Add Task
        </button>
    </form>

    <ul style="list-style: none; padding: 0; margin: 0;">

        @forelse ($tasks as $index => $task)
            <li
                wire:key="task-{{ $task['id'] }}"
                style="border: 1px solid #999; border-radius: 5px; padding: 12px; margin-bottom: 8px;"
            >

                @if ($editIndex === $index)

                    <form wire:submit="updateTask"
                          style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">

                        <input
                            type="text"
                            wire:model="editTitle"
                            style="flex: 1 1 200px; min-width: 150px; padding: 10px; border: 1px solid #999; border-radius: 5px;"
                        >

                        <button
                            type="submit"
                            style="display: inline-block !important; visibility: visible !important; opacity: 1 !important; background-color: #15803d; color: white; padding: 10px 16px; border: 0; border-radius: 5px; cursor: pointer;"
                        >
                            Save
                        </button>

                        <button
                            type="button"
                            wire:click="cancelEdit"
                            style="display: inline-block !important; visibility: visible !important; background-color: #eeeeee; color: black; padding: 10px 16px; border: 1px solid #999; border-radius: 5px; cursor: pointer;"
                        >
                            Cancel
                        </button>

                    </form>

                @else

                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">

                        <span style="overflow-wrap: anywhere;">
                            {{ $task['title'] }}
                        </span>

                        <div style="display: flex; align-items: center; gap: 14px;">

                            <button
                                type="button"
                                wire:click="editTask({{ $task['id'] }})"
                                style="display: inline-block; background: transparent; color: #2563eb; border: 0; cursor: pointer; font-size: 16px;"
                            >
                                Edit
                            </button>

                            <button
                                type="button"
                                wire:click="deleteTask({{ $task['id'] }})"
                                wire:confirm="Are you sure you want to delete this task?"
                                style="display: inline-block; background: transparent; color: #dc2626; border: 0; cursor: pointer; font-size: 16px;"
                            >
                                Delete
                            </button>

                        </div>
                    </div>

                @endif

            </li>

        @empty
            <li style="border: 1px solid #ddd; padding: 12px; border-radius: 5px; color: #666;">
                No tasks yet. Add your first task!
            </li>
        @endforelse

    </ul>
</div>
