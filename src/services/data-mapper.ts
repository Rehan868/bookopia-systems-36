
/**
 * This file provides mapping functions to convert between the database schema and the frontend models
 */

import { Json } from '@/integrations/supabase/types';
import { Booking, CleaningTask, Expense, Owner, Room, User } from './supabase-types';

// Maps booking data from database schema to frontend model
export const mapBookingFromDb = (booking: any): Booking => {
  return {
    id: booking.id?.toString() || '',
    room_id: booking.room_id?.toString() || '',
    booking_number: booking.confirmation_code || `BK-${booking.id}`,
    guest_name: booking.guest_name || 'Guest',
    check_in: booking.check_in_date || '',
    check_out: booking.check_out_date || '',
    amount: booking.total_price || 0,
    status: booking.status || 'confirmed',
    payment_status: booking.payment_status || 'pending',
    special_requests: booking.special_requests || '',
    created_at: booking.created_at || '',
    updated_at: booking.updated_at || '',
    // Additional fields
    adults: booking.adults || 1,
    children: booking.children || 0,
    confirmation_code: booking.confirmation_code,
    notes: booking.notes || '',
    payment_method: booking.payment_method,
    total_price: booking.total_price || 0,
    rooms: booking.rooms
  };
};

// Maps room data from database schema to frontend model
export const mapRoomFromDb = (room: any): Room => {
  return {
    id: room.id?.toString() || '',
    room_number: room.room_number || '',
    type: room.room_type_id?.toString() || '',
    capacity: room.max_occupancy || 2,
    rate: room.base_price || 0,
    status: room.status || 'available',
    floor: room.floor?.toString() || '1',
    description: room.description || '',
    amenities: Array.isArray(room.amenities) 
      ? room.amenities
      : typeof room.amenities === 'object' && room.amenities !== null
        ? Object.keys(room.amenities)
        : [],
    features: room.amenities || {},
    created_at: room.created_at || '',
    updated_at: room.updated_at || '',
    property: room.property_id?.toString() || '',
    property_id: room.property_id,
    room_type_id: room.room_type_id,
    base_price: room.base_price,
    max_occupancy: room.max_occupancy,
    cleaning_status: room.cleaning_status
  };
};

// Maps expense data from database schema to frontend model
export const mapExpenseFromDb = (expense: any): Expense => {
  return {
    id: expense.id?.toString() || '',
    description: expense.description || '',
    amount: expense.amount || 0,
    date: expense.expense_date || '',
    expense_date: expense.expense_date || '',
    category: expense.category || '',
    payment_method: expense.payment_method || '',
    status: expense.status || 'pending',
    created_at: expense.created_at || '',
    updated_at: expense.updated_at || '',
    property_id: expense.property_id,
    room_id: expense.room_id,
    receipt_image: expense.receipt_image,
    created_by: expense.created_by,
    paid_by: expense.paid_by
  };
};

// Maps user data from database schema to frontend model
export const mapUserFromDb = (user: any): User => {
  return {
    id: user.id?.toString() || '',
    name: user.name || '',
    email: user.email || '',
    role: user.role || 'user',
    status: 'active', // Default value since it's missing in the database
    avatar_url: user.avatar || null,
    created_at: user.created_at || '',
    updated_at: user.updated_at || '',
    avatar: user.avatar,
    phone: user.phone,
    last_active: user.last_active
  };
};

// Maps owner data from database schema to frontend model
export const mapOwnerFromDb = (owner: any): Owner => {
  if (!owner) return {} as Owner;

  // Extract payment details safely
  const paymentDetails = typeof owner.payment_details === 'object' && owner.payment_details !== null
    ? owner.payment_details
    : {};

  const paymentInfo = {
    bank: typeof paymentDetails === 'object' ? (paymentDetails as any)?.bank || '' : '',
    accountNumber: typeof paymentDetails === 'object' ? (paymentDetails as any)?.account_number || '' : '',
    routingNumber: typeof paymentDetails === 'object' ? (paymentDetails as any)?.routing_number || '' : ''
  };
    
  return {
    id: owner.id?.toString() || '',
    first_name: owner.first_name || '',
    last_name: owner.last_name || '',
    name: `${owner.first_name || ''} ${owner.last_name || ''}`,
    email: owner.email || '',
    phone: owner.phone || null,
    properties: 0, // Default or calculated value
    revenue: 0, // Default or calculated value
    occupancy: 0, // Default or calculated value
    avatar: null, // Default value
    payment_details: owner.payment_details,
    payment_info: paymentDetails,
    paymentDetails: paymentInfo,
    joinedDate: owner.created_at?.split('T')[0] || '',
    created_at: owner.created_at || '',
    updated_at: owner.updated_at || ''
  };
};

export const mapCleaningTaskFromDb = (task: any): CleaningTask => {
  return {
    id: task.id?.toString() || '',
    room_id: task.room_id?.toString() || '',
    room: {
      number: task.rooms?.room_number || 'Unknown',
      property: task.rooms?.property_id?.toString() || 'Unknown'
    },
    status: task.status || 'pending',
    scheduled_date: task.created_at || '',
    assigned_to: task.cleaned_by?.toString() || null,
    notes: task.notes || null,
    created_at: task.created_at || '',
    completed_at: task.cleaned_at || null,
    cleaned_at: task.cleaned_at,
    cleaned_by: task.cleaned_by,
    inspected_at: task.inspected_at,
    inspected_by: task.inspected_by
  };
};
