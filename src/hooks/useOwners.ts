
import { useState, useEffect } from 'react';
import { fetchOwners, fetchPropertyOwnership, getById, create, update, remove, createAuditLog } from '../services/api';
import { PropertyOwnership } from '../services/supabase-types';
import { Owner as OwnerType } from '../services/supabase-types';

// Define the extended owner interface for the hook
export interface Owner extends OwnerType {
  properties?: number;
  revenue?: number;
  occupancy?: number;
  avatar?: string;
  joinedDate?: string;
  paymentDetails?: {
    bank: string;
    accountNumber: string;
    routingNumber: string;
  };
}

export function useOwners() {
  const [data, setData] = useState<Owner[] | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const owners = await fetchOwners();
        setData(owners as Owner[]);
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  // Function to add a new owner
  const addOwner = async (owner: Omit<Owner, 'id' | 'created_at' | 'updated_at'>) => {
    try {
      setIsLoading(true);
      const newOwner = await create<Owner>('owners', owner);
      setData(prevData => prevData ? [...prevData, newOwner] : [newOwner]);
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'create', 'owner', newOwner.id, { name: newOwner.name });
      
      setIsLoading(false);
      return newOwner;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  // Function to update an owner
  const updateOwner = async (id: string, ownerData: Partial<Owner>) => {
    try {
      setIsLoading(true);
      const updatedOwner = await update<Owner>('owners', id, ownerData);
      setData(prevData => 
        prevData ? prevData.map(owner => 
          owner.id === id ? { ...owner, ...updatedOwner } : owner
        ) : null
      );
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'update', 'owner', id, { name: updatedOwner.name });
      
      setIsLoading(false);
      return updatedOwner;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  // Function to delete an owner
  const deleteOwner = async (id: string) => {
    try {
      setIsLoading(true);
      await remove('owners', id);
      setData(prevData => 
        prevData ? prevData.filter(owner => owner.id !== id) : null
      );
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'delete', 'owner', id);
      
      setIsLoading(false);
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  return { data, isLoading, error, addOwner, updateOwner, deleteOwner };
}

// Add the useOwner hook for individual owner data
export function useOwner(id: string) {
  const [data, setData] = useState<Owner | null>(null);
  const [ownedRooms, setOwnedRooms] = useState<PropertyOwnership[] | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<any>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        
        // Fetch owner data
        const owner = await getById<Owner>('owners', id);
        setData(owner);
        
        // Fetch owner's room information
        const propertyOwnerships = await fetchPropertyOwnership();
        const ownerRooms = propertyOwnerships.filter(po => po.owner_id === id);
        setOwnedRooms(ownerRooms);
        
        setIsLoading(false);
      } catch (err) {
        setError(err);
        setIsLoading(false);
      }
    };

    fetchData();
  }, [id]);

  // Function to update an owner
  const updateOwner = async (ownerData: Partial<Owner>) => {
    if (!id) return;
    
    try {
      setIsLoading(true);
      const updatedOwner = await update<Owner>('owners', id, ownerData);
      setData(prevData => prevData ? { ...prevData, ...updatedOwner } : updatedOwner);
      
      // Create audit log
      const userId = localStorage.getItem('userId');
      await createAuditLog(userId, 'update', 'owner', id, { name: updatedOwner.name });
      
      setIsLoading(false);
      return updatedOwner;
    } catch (err) {
      setError(err);
      setIsLoading(false);
      throw err;
    }
  };

  return { data, ownedRooms, isLoading, error, updateOwner };
}
