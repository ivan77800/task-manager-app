'use client';

import { Task } from '../types/task';
import TaskCard from './TaskCard';

interface TaskListProps {
  tasks: Task[];
  onTaskDeleted: (taskId: number) => void;
  onTaskUpdated: (task: Task) => void;
}

export default function TaskList({ tasks, onTaskDeleted, onTaskUpdated }: TaskListProps) {
  if (tasks.length === 0) {
    return (
      <div className="text-center py-8 text-gray-500">
        No tasks found. Create your first task above!
      </div>
    );
  }

  const highPriorityTasks = tasks.filter(task => task.priority === 'high');
  const mediumPriorityTasks = tasks.filter(task => task.priority === 'medium');
  const lowPriorityTasks = tasks.filter(task => task.priority === 'low');

  return (
    <div className="space-y-6">
      {highPriorityTasks.length > 0 && (
        <div>
          <h3 className="text-lg font-semibold text-red-600 mb-3">High Priority</h3>
          <div className="space-y-3">
            {highPriorityTasks.map(task => (
              <TaskCard
                key={task.id}
                task={task}
                onDeleted={onTaskDeleted}
                onUpdated={onTaskUpdated}
              />
            ))}
          </div>
        </div>
      )}

      {mediumPriorityTasks.length > 0 && (
        <div>
          <h3 className="text-lg font-semibold text-yellow-600 mb-3">Medium Priority</h3>
          <div className="space-y-3">
            {mediumPriorityTasks.map(task => (
              <TaskCard
                key={task.id}
                task={task}
                onDeleted={onTaskDeleted}
                onUpdated={onTaskUpdated}
              />
            ))}
          </div>
        </div>
      )}

      {lowPriorityTasks.length > 0 && (
        <div>
          <h3 className="text-lg font-semibold text-green-600 mb-3">Low Priority</h3>
          <div className="space-y-3">
            {lowPriorityTasks.map(task => (
              <TaskCard
                key={task.id}
                task={task}
                onDeleted={onTaskDeleted}
                onUpdated={onTaskUpdated}
              />
            ))}
          </div>
        </div>
      )}
    </div>
  );
}
