import { useState, useEffect } from 'react';
import { fetchCleaningTasks, create, update, remove, getById, createAuditLog } from '../services/api';
import { CleaningTask } from '../services/supabase-types';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { updateCleaningTaskStatus } from '@/services/api';
import { useToast } from './use-toast';

export function useCleaningTasks() {
  const [data, setData] = useState<CleaningTask[] | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const tasks = await fetchCleaningTasks();
        setData(tasks);
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  // Function to add a new cleaning task
  const addCleaningTask = async (task: Omit<CleaningTask, 'id' | 'created_at' | 'updated_at'>) => {
    try {
      setIsLoading(true);
      const newTask = await create<CleaningTask>('cleaning_tasks', task);
      setData(prevData => prevData ? [...prevData, newTask] : [newTask]);
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'create', 'cleaning_task', newTask.id, { room_id: newTask.room_id });
      
      setIsLoading(false);
      return newTask;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  // Function to update a cleaning task
  const updateCleaningTask = async (id: string, taskData: Partial<CleaningTask>) => {
    try {
      setIsLoading(true);
      const updatedTask = await update<CleaningTask>('cleaning_tasks', id, taskData);
      setData(prevData => 
        prevData ? prevData.map(task => 
          task.id === id ? { ...task, ...updatedTask } : task
        ) : null
      );
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'update', 'cleaning_task', id, { status: updatedTask.status });
      
      setIsLoading(false);
      return updatedTask;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  // Function to delete a cleaning task
  const deleteCleaningTask = async (id: string) => {
    try {
      setIsLoading(true);
      await remove('cleaning_tasks', id);
      setData(prevData => 
        prevData ? prevData.filter(task => task.id !== id) : null
      );
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'delete', 'cleaning_task', id);
      
      setIsLoading(false);
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  return { data, isLoading, error, addCleaningTask, updateCleaningTask, deleteCleaningTask };
}

// Add the useCleaningTask hook for individual cleaning task data
export function useCleaningTask(id: string) {
  const [data, setData] = useState<CleaningTask | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const task = await getById<CleaningTask>('cleaning_tasks', id);
        setData(task);
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, [id]);

  // Function to update a cleaning task
  const updateCleaningTask = async (taskData: Partial<CleaningTask>) => {
    if (!id) return;
    
    try {
      setIsLoading(true);
      const updatedTask = await update<CleaningTask>('cleaning_tasks', id, taskData);
      setData(prevData => prevData ? { ...prevData, ...updatedTask } : updatedTask);
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'update', 'cleaning_task', id, { status: updatedTask.status });
      
      setIsLoading(false);
      return updatedTask;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  return { data, isLoading, error, updateCleaningTask };
}

export const useUpdateCleaningTaskStatus = () => {
  const queryClient = useQueryClient();
  const { toast } = useToast();
  
  return useMutation({
    mutationFn: ({ id, status }: { id: string, status: string }) => {
      return updateCleaningTaskStatus(id, status);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['cleaning-tasks'] });
      toast({
        title: 'Cleaning task updated',
        description: 'The cleaning task status has been updated successfully',
      });
    },
    onError: (error) => {
      toast({
        title: 'Failed to update cleaning task',
        description: error.message,
        variant: 'destructive',
      });
    }
  });
};
