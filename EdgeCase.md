Edge Case: Prevent duplicate tasks with same title within 10 seconds

How it works: Backend checks for existing task with same title in last 10 seconds using created_at timestamp.

# Create first task
curl -X POST http://localhost:8001/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title":"Test Task","description":"First","status":"pending","priority":"high"}'

# Try duplicate immediately (should fail)
curl -X POST http://localhost:8001/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title":"Test Task","description":"Duplicate","status":"pending","priority":"medium"}'

# Expected Response (409 Conflict):
{
  "success": false,
  "message": "A task with the same title was created less than 10 seconds ago. Please wait before creating another duplicate task."
}

# Wait 11 seconds and try again (should succeed)
sleep 11
curl -X POST http://localhost:8001/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title":"Test Task","description":"After 10 seconds","status":"pending","priority":"low"}'