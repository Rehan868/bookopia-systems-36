
export type Room = {
  id: string;
  room_number: string;
  type: string;
  capacity: number;
  rate: number;
  status: 'available' | 'occupied' | 'maintenance';
  floor: string;
  description: string | null;
  amenities: any[];
  features: any;
  created_at: string;
  updated_at: string;
  property?: string; // Adding property field as it's used in RoomList component
  maintenance?: boolean; // Adding maintenance field used in other components
  lastCleaned?: string; // Adding lastCleaned field
  nextCheckIn?: string | null; // Adding nextCheckIn field
  // Fields from the database
  property_id?: number;
  room_type_id?: number;
  base_price?: number;
  max_occupancy?: number;
  cleaning_status?: string;
};

export type Booking = {
  id: string;
  room_id: string;
  booking_number?: string;
  guest_name?: string;
  check_in: string;
  check_out: string;
  amount?: number;
  status: string;
  payment_status: string;
  special_requests: string | null;
  created_at: string;
  updated_at: string;
  rooms?: any; // Adding rooms property that comes from join queries
  // Fields from the database
  adults?: number;
  children?: number;
  check_in_date?: string;
  check_out_date?: string;
  confirmation_code?: string;
  guest_id?: number;
  total_price?: number;
  notes?: string;
  payment_method?: string;
};

export type User = {
  id: string;
  name: string;
  email: string;
  role: string;
  status?: string;
  avatar_url?: string | null;
  last_active?: string | null;
  created_at: string;
  updated_at: string;
  // Fields from the database
  avatar?: string;
  phone?: string;
  password?: string;
  remember_token?: string;
  email_verified_at?: string;
};

export type Owner = {
  id: string;
  first_name: string;
  last_name: string;
  name?: string; // Computed field
  email: string;
  phone: string | null;
  payment_info?: any;
  payment_details?: any;
  created_at: string;
  updated_at: string;
  properties?: number; // For frontend use
  revenue?: number; // For frontend use
  occupancy?: number; // For frontend use
  avatar?: string;
  paymentDetails?: {
    bank: string;
    accountNumber: string;
    routingNumber: string;
  };
  joinedDate?: string;
};

export type Expense = {
  id: string;
  description: string;
  amount: number;
  date?: string;
  expense_date?: string; // From the database
  category: string;
  payment_method: string;
  status: string;
  created_at: string;
  updated_at: string;
  property_id?: number;
  room_id?: number;
  receipt_image?: string;
  created_by?: number;
  paid_by?: number;
};

export type CleaningTask = {
  id: string;
  room_id: string;
  room?: {
    number: string;
    property: string;
  };
  status: string;
  scheduled_date?: string;
  assigned_to?: string | null;
  notes?: string | null;
  created_at: string;
  completed_at?: string | null;
  // Fields from the database
  cleaned_at?: string;
  cleaned_by?: number;
  inspected_at?: string;
  inspected_by?: number;
};

export type PropertyOwnership = {
  id: string;
  room_id: string;
  owner_id: string;
  commission_rate: number;
  contract_start_date: string;
  contract_end_date: string | null;
  created_at: string;
  updated_at: string;
};
