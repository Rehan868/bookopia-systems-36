
import { useState, useEffect } from 'react';
import { fetchBookings, fetchBookingById, fetchTodayCheckins, fetchTodayCheckouts, create, update, remove, createAuditLog } from '../services/api';
import { Booking } from '../services/supabase-types';

export function useBookings() {
  const [data, setData] = useState<Booking[] | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const bookings = await fetchBookings();
        setData(bookings);
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  // Function to add a new booking
  const addBooking = async (booking: Omit<Booking, 'id' | 'created_at' | 'updated_at'>) => {
    try {
      setIsLoading(true);
      const newBooking = await create<Booking>('bookings', booking);
      setData(prevData => prevData ? [...prevData, newBooking] : [newBooking]);
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'create', 'booking', newBooking.id, { booking_number: newBooking.booking_number });
      
      setIsLoading(false);
      return newBooking;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  // Function to update a booking
  const updateBooking = async (id: string, bookingData: Partial<Booking>) => {
    try {
      setIsLoading(true);
      const updatedBooking = await update<Booking>('bookings', id, bookingData);
      setData(prevData => 
        prevData ? prevData.map(booking => 
          booking.id === id ? { ...booking, ...updatedBooking } : booking
        ) : null
      );
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'update', 'booking', id, { booking_number: updatedBooking.booking_number });
      
      setIsLoading(false);
      return updatedBooking;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  // Function to delete a booking
  const deleteBooking = async (id: string) => {
    try {
      setIsLoading(true);
      await remove('bookings', id);
      setData(prevData => 
        prevData ? prevData.filter(booking => booking.id !== id) : null
      );
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'delete', 'booking', id);
      
      setIsLoading(false);
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  return { data, isLoading, error, addBooking, updateBooking, deleteBooking };
}

// Add the useBooking hook for individual booking data
export function useBooking(id: string) {
  const [data, setData] = useState<Booking | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const booking = await fetchBookingById(id);
        setData(booking);
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, [id]);

  // Function to update a booking
  const updateBooking = async (bookingData: Partial<Booking>) => {
    if (!id) return;
    
    try {
      setIsLoading(true);
      const updatedBooking = await update<Booking>('bookings', id, bookingData);
      setData(prevData => prevData ? { ...prevData, ...updatedBooking } : updatedBooking);
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'update', 'booking', id, { booking_number: updatedBooking.booking_number });
      
      setIsLoading(false);
      return updatedBooking;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  return { data, isLoading, error, updateBooking };
}

// Add the useTodayCheckins hook
export function useTodayCheckins() {
  const [data, setData] = useState<Booking[] | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const checkins = await fetchTodayCheckins();
        setData(checkins);
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  return { data, isLoading, error };
}

// Add the useTodayCheckouts hook
export function useTodayCheckouts() {
  const [data, setData] = useState<Booking[] | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const checkouts = await fetchTodayCheckouts();
        setData(checkouts);
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  return { data, isLoading, error };
}
