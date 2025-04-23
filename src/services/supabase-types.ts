
import { Json } from '@/integrations/supabase/database.types';

// Entity Types
export interface User {
  id: string;
  email: string;
  name: string;
  role: string;
  status: string;
  avatar_url?: string | null;
  last_active?: string | null;
  created_at?: string | null;
  updated_at?: string | null;
}

export interface Booking {
  id: string;
  property_id?: string | null;
  room_id?: string | null;
  guest_id?: string | null;
  booking_number: string;
  guest_name: string;
  check_in: string;
  check_out: string;
  adults: number;
  children: number;
  amount: number;
  payment_status?: string | null;
  status: string;
  special_requests?: string | null;
  created_by?: string | null;
  created_at?: string | null;
  updated_at?: string | null;
  // Renamed fields to match database schema
  amount_paid?: number | null;
  remaining_amount?: number | null;
  guest_email?: string | null;
  guest_phone?: string | null;
  commission?: number | null;
  vat?: number | null;
  tourism_fee?: number | null;
  net_to_owner?: number | null;
  security_deposit?: number | null;
  // Aliases for backward compatibility with component usage
  guestEmail?: string | null;
  guestPhone?: string | null;
  guestDocument?: string | null;
  baseRate?: number | null;
  securityDeposit?: number | null;
  tourismFee?: number | null;
  netToOwner?: number | null;
  amountPaid?: number | null;
  remainingAmount?: number | null;
  notes?: string | null;
  rooms?: Room;
  property?: Property;
}

export interface Room {
  id: string;
  property_id?: string | null;
  room_type_id?: string | null;
  number: string;
  floor: string;
  type: string;
  description?: string | null;
  capacity: number;
  rate: number;
  status: string;
  amenities?: string[] | null;
  features?: Json | null;
  created_at?: string | null;
  updated_at?: string | null;
  // Field for backward compatibility
  name?: string;
  property?: string;
  room_types?: RoomType;
  properties?: Property;
}

export interface RoomType {
  id: string;
  property_id?: string | null;
  name: string;
  description?: string | null;
  base_rate: number;
  max_occupancy: number;
  created_at?: string | null;
  updated_at?: string | null;
}

export interface Property {
  id: string;
  name: string;
  address: string;
  city: string;
  state?: string | null;
  country: string;
  postal_code?: string | null;
  phone?: string | null;
  email?: string | null;
  website?: string | null;
  tax_rate?: number | null;
  timezone?: string | null;
  check_in_time?: string | null;
  check_out_time?: string | null;
  created_at?: string | null;
  updated_at?: string | null;
}

export interface CleaningTask {
  id: string;
  property_id?: string | null;
  room_id: string;
  assigned_to?: string | null;
  date: string;
  status: string;
  notes?: string | null;
  created_at?: string | null;
  updated_at?: string | null;
  rooms?: Room;
  properties?: Property;
  users?: User;
}

export interface Owner {
  id: string;
  name: string;
  email: string;
  phone?: string | null;
  payment_info?: Json | null;
  created_at?: string | null;
  updated_at?: string | null;
  // Fields for backward compatibility
  properties?: any[];
  revenue?: number;
  occupancy?: number;
  avatar?: string;
  joinedDate?: string;
  paymentDetails?: any;
}

export interface PropertyOwnership {
  id: string;
  owner_id?: string | null;
  room_id?: string | null;
  commission_rate: number;
  contract_start_date: string;
  contract_end_date?: string | null;
  created_at?: string | null;
  updated_at?: string | null;
  owners?: Owner;
  rooms?: Room;
}

export interface Expense {
  id: string;
  property_id?: string | null;
  category: string;
  description: string;
  amount: number;
  date: string;
  payment_method: string;
  status: string;
  created_by?: string | null;
  created_at?: string | null;
  updated_at?: string | null;
  properties?: Property;
  users?: User;
}

export interface Guest {
  id: string;
  first_name: string;
  last_name: string;
  email?: string | null;
  phone?: string | null;
  address?: string | null;
  city?: string | null;
  state?: string | null;
  country?: string | null;
  postal_code?: string | null;
  id_type?: string | null;
  id_number?: string | null;
  notes?: string | null;
  created_at?: string | null;
  updated_at?: string | null;
}

export interface Notification {
  id: string;
  user_id?: string | null;
  title: string;
  message: string;
  is_read?: boolean | null;
  created_at?: string | null;
}

export interface AuditLog {
  id: string;
  user_id?: string | null;
  action: string;
  resource_type?: string | null;
  resource_id?: string | null;
  details?: Json | null;
  created_at?: string | null;
}

// Dashboard statistics interface
export interface DashboardStats {
  totalRooms: number;
  availableRooms: number;
  occupiedRooms: number;
  todayCheckins: number;
  todayCheckouts: number;
  // Aliases for backward compatibility
  todayCheckIns?: number;
  todayCheckOuts?: number;
  weeklyOccupancyTrend?: number[];
  revenue: {
    today: number;
    thisWeek: number;
    thisMonth: number;
  };
  occupancyRate: number;
  recentBookings: Booking[];
}
