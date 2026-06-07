'use client';

import { useState, useEffect } from 'react';
import TaskList from '../components/TaskList';
import TaskForm from '../components/TaskForm';
import { Task } from '../types/task';

export default function Home() {
  const [tasks, setTasks] = useState<Task[]>([]);
  const [loading, setLoading] = useState(true);
  const [filter, setFilter] = useState<string>('');

  const fetchTasks = async (statusFilter = '') => {
    try {
      setLoading(true);
      const url = statusFilter 
        ? `${process.env.NEXT_PUBLIC_API_URL}/api/tasks?status=${statusFilter}`
        : `${process.env.NEXT_PUBLIC_API_URL}/api/tasks`;
      
      const response = await fetch(url);
      const result = await response.json();
      
      if (result.success) {
        setTasks(result.data);
      }
    } catch (error) {
      console.error('Error fetching tasks:', error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchTasks(filter);
  }, [filter]);

  const handleTaskCreated = () => {
    fetchTasks(filter);
  };

  const handleTaskDeleted = (taskId: number) => {
    setTasks(tasks.filter(task => task.id !== taskId));
  };

  const handleTaskUpdated = (updatedTask: Task) => {
    setTasks(tasks.map(task => task.id === updatedTask.id ? updatedTask : task));
  };

  return (
    <main className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
      <div className="container mx-auto px-4 max-w-4xl">
        <h1 className="text-4xl font-bold text-center text-gray-800 mb-8">
          Task Management System
        </h1>
        
        <div className="bg-white rounded-lg shadow-lg p-6 mb-8">
          <TaskForm onTaskCreated={handleTaskCreated} />
        </div>

        <div className="bg-white rounded-lg shadow-lg p-6">
          <div className="mb-6 flex justify-between items-center">
            <h2 className="text-2xl font-semibold text-gray-800">Your Tasks</h2>
            <select
              value={filter}
              onChange={(e) => setFilter(e.target.value)}
              className="px-4 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">All Tasks</option>
              <option value="pending">Pending</option>
              <option value="completed">Completed</option>
            </select>
          </div>

          {loading ? (
            <div className="text-center py-8">
              <div className="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            </div>
          ) : (
            <TaskList 
              tasks={tasks} 
              onTaskDeleted={handleTaskDeleted}
              onTaskUpdated={handleTaskUpdated}
            />
          )}
        </div>
      </div>
    </main>
  );
}