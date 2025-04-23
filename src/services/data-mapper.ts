
/**
 * This file provides mapping functions to convert between the database schema and the frontend models
 */

import { supabase } from '@/integrations/supabase/client';

// Maps booking data from database schema to frontend model
export const mapBookingFromDb = (booking: any) => {
  return {
    id: booking.id.toString(),
    reference: booking.confirmation_code || `BK-${booking.id}`,
    guestName: booking.guest_name || 'Guest',
    guestEmail: booking.guest_email || '',
    guestPhone: booking.guest_phone || '',
    property: booking.room_id ? 'Property' : 'Unknown', // This would need to be fetched or joined
    roomNumber: booking.room_id?.toString() || 'Unknown',
    checkIn: booking.check_in_date,
    checkOut: booking.check_out_date,
    adults: booking.adults || 1,
    children: booking.children || 0,
    baseRate: 0, // Would need calculation
    totalAmount: booking.total_price || 0,
    notes: booking.notes || '',
    status: booking.status || 'confirmed',
    paymentStatus: booking.payment_status || 'pending',
    sendConfirmation: false,
  };
};

// Maps room data from database schema to frontend model
export const mapRoomFromDb = (room: any) => {
  return {
    id: room.id?.toString(),
    roomNumber: room.room_number || '',
    property: room.property_id?.toString() || '',
    type: room.room_type_id?.toString() || '',
    maxOccupancy: room.max_occupancy?.toString() || '2',
    basePrice: room.base_price?.toString() || '0',
    description: room.description || '',
    amenities: Array.isArray(room.amenities) 
      ? room.amenities.join('\n') 
      : typeof room.amenities === 'object' 
        ? Object.keys(room.amenities).join('\n')
        : '',
    status: room.status || 'available',
    owner: room.owner_id?.toString() || '',
    isActive: room.is_active === undefined ? true : room.is_active,
  };
};

// Maps expense data from database schema to frontend model
export const mapExpenseFromDb = (expense: any) => {
  return {
    id: expense.id?.toString(),
    description: expense.description || '',
    amount: expense.amount || 0,
    date: expense.expense_date || '',
    category: expense.category || '',
    property: expense.property_id?.toString() || '',
    vendor: expense.vendor || '',
    paymentMethod: expense.payment_method || '',
    notes: expense.notes || ''
  };
};

// Maps user data from database schema to frontend model
export const mapUserFromDb = (user: any) => {
  return {
    id: user.id?.toString(),
    name: user.name || '',
    email: user.email || '',
    role: user.role || 'user',
    avatar: user.avatar || ''
  };
};

// Maps owner data from database schema to frontend model
export const mapOwnerFromDb = (owner: any) => {
  if (!owner) return null;
  
  const paymentDetails = typeof owner.payment_details === 'object' 
    ? owner.payment_details 
    : {};
    
  return {
    id: owner.id?.toString(),
    name: `${owner.first_name || ''} ${owner.last_name || ''}`,
    first_name: owner.first_name || '',
    last_name: owner.last_name || '',
    email: owner.email || '',
    phone: owner.phone || null,
    properties: 0, // Would need to be counted from related tables
    revenue: 0, // Would need calculation
    occupancy: 0, // Would need calculation
    avatar: null, // Would need to be set properly
    paymentDetails: {
      bank: paymentDetails.bank || '',
      accountNumber: paymentDetails.account_number || '',
      routingNumber: paymentDetails.routing_number || ''
    },
    joinedDate: owner.created_at?.split('T')[0] || ''
  };
};
