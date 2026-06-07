## API Documentation

### Base URL: `http://localhost:8001/api`

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/tasks` | Get all tasks |
| GET | `/tasks?status=pending` | Filter by status |
| POST | `/tasks` | Create task |
| PUT | `/tasks/{id}` | Update task |
| DELETE | `/tasks/{id}` | Delete task |

### Example Requests
```bash
# Get all tasks
curl http://localhost:8001/api/tasks

# Create task
curl -X POST http://localhost:8001/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title":"Task","status":"pending","priority":"high"}'