import { useState, useEffect } from 'react';
import { fetchRooms, fetchRoomById, create, update, remove, createAuditLog } from '../services/api';
import { Room } from '../services/supabase-types';

export function useRooms() {
  const [data, setData] = useState<Room[] | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const rooms = await fetchRooms();
        setData(rooms);
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  // Function to add a new room
  const addRoom = async (room: Omit<Room, 'id' | 'created_at' | 'updated_at'>) => {
    try {
      setIsLoading(true);
      const newRoom = await create<Room>('rooms', room);
      setData(prevData => prevData ? [...prevData, newRoom] : [newRoom]);
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'create', 'room', newRoom.id, { room_number: newRoom.number });
      
      setIsLoading(false);
      return newRoom;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  // Function to update a room
  const updateRoom = async (id: string, roomData: Partial<Room>) => {
    try {
      setIsLoading(true);
      const updatedRoom = await update<Room>('rooms', id, roomData);
      setData(prevData => 
        prevData ? prevData.map(room => 
          room.id === id ? { ...room, ...updatedRoom } : room
        ) : null
      );
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'update', 'room', id, { room_number: updatedRoom.number });
      
      setIsLoading(false);
      return updatedRoom;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  // Function to delete a room
  const deleteRoom = async (id: string) => {
    try {
      setIsLoading(true);
      await remove('rooms', id);
      setData(prevData => 
        prevData ? prevData.filter(room => room.id !== id) : null
      );
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'delete', 'room', id);
      
      setIsLoading(false);
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  return { data, isLoading, error, addRoom, updateRoom, deleteRoom };
}

// Add the useRoom hook for individual room data
export function useRoom(id: string) {
  const [data, setData] = useState<Room | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const room = await fetchRoomById(id);
        setData(room);
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, [id]);

  // Function to update a room
  const updateRoom = async (roomData: Partial<Room>) => {
    if (!id) return;
    
    try {
      setIsLoading(true);
      const updatedRoom = await update<Room>('rooms', id, roomData);
      setData(prevData => prevData ? { ...prevData, ...updatedRoom } : updatedRoom);
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'update', 'room', id, { room_number: updatedRoom.number });
      
      setIsLoading(false);
      return updatedRoom;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  return { data, isLoading, error, updateRoom };
}
