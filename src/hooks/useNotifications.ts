import { useState, useEffect } from 'react';
import { supabase } from '../integrations/supabase';
import { getAll, create, update, query } from '../services/api';
import { Notification } from '../services/supabase-types';

export function useNotifications(userId?: string) {
  const [notifications, setNotifications] = useState<Notification[]>([]);
  const [unreadCount, setUnreadCount] = useState<number>(0);
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [error, setError] = useState<Error | null>(null);

  useEffect(() => {
    // Skip if no userId is provided
    if (!userId) {
      setIsLoading(false);
      return;
    }

    const fetchNotifications = async () => {
      try {
        setIsLoading(true);
        
        // Get notifications for this user, ordered by creation time (newest first)
        const userNotifications = await query<Notification>('notifications', {
          filters: { user_id: userId },
          order: { column: 'created_at', ascending: false }
        });
        
        setNotifications(userNotifications);
        
        // Count unread notifications
        const unread = userNotifications.filter(n => n.is_read === false).length;
        setUnreadCount(unread);
        
        setIsLoading(false);
      } catch (err) {
        console.error('Error fetching notifications:', err);
        setError(err as Error);
        setIsLoading(false);
      }
    };

    fetchNotifications();

    // Set up real-time subscription for new notifications
    const subscription = supabase
      .channel('notifications-channel')
      .on(
        'postgres_changes',
        { 
          event: 'INSERT', 
          schema: 'public', 
          table: 'notifications',
          filter: `user_id=eq.${userId}`
        },
        (payload) => {
          // Add new notification to state
          const newNotification = payload.new as Notification;
          setNotifications(prev => [newNotification, ...prev]);
          setUnreadCount(prev => prev + 1);
        }
      )
      .subscribe();

    // Cleanup subscription on unmount
    return () => {
      subscription.unsubscribe();
    };
  }, [userId]);

  // Mark a notification as read
  const markAsRead = async (notificationId: string) => {
    try {
      await update<Notification>('notifications', notificationId, { is_read: true });
      
      // Update local state
      setNotifications(prev => 
        prev.map(n => n.id === notificationId ? { ...n, is_read: true } : n)
      );
      
      // Update unread count
      setUnreadCount(prev => Math.max(0, prev - 1));
    } catch (err) {
      console.error('Error marking notification as read:', err);
      throw err;
    }
  };

  // Mark all notifications as read
  const markAllAsRead = async () => {
    try {
      // Get all unread notification IDs
      const unreadIds = notifications
        .filter(n => !n.is_read)
        .map(n => n.id);
      
      if (unreadIds.length === 0) return;
      
      // Update all unread notifications in a batch
      for (const id of unreadIds) {
        await update<Notification>('notifications', id, { is_read: true });
      }
      
      // Update local state
      setNotifications(prev => 
        prev.map(n => ({ ...n, is_read: true }))
      );
      
      // Reset unread count
      setUnreadCount(0);
    } catch (err) {
      console.error('Error marking all notifications as read:', err);
      throw err;
    }
  };

  // Create a new notification
  const createNotification = async (notification: Omit<Notification, 'id' | 'created_at'>) => {
    try {
      const newNotification = await create<Notification>('notifications', {
        ...notification,
        created_at: new Date().toISOString()
      });
      return newNotification;
    } catch (err) {
      console.error('Error creating notification:', err);
      throw err;
    }
  };

  return { 
    notifications, 
    unreadCount, 
    isLoading, 
    error,
    markAsRead,
    markAllAsRead,
    createNotification
  };
}