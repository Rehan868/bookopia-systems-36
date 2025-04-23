import { Route, Routes, Navigate, useLocation, Outlet } from 'react-router-dom';
import { AuthProvider, useAuth } from './hooks/use-auth';
import { NotificationProvider } from './components/layout/NotificationProvider';

// Regular staff pages
import Dashboard from './pages/Dashboard';
import Bookings from './pages/Bookings';
import BookingAdd from './pages/BookingAdd';
import BookingEdit from './pages/BookingEdit';
import BookingView from './pages/BookingView';
import Rooms from './pages/Rooms';
import RoomAdd from './pages/RoomAdd';
import RoomEdit from './pages/RoomEdit';
import RoomView from './pages/RoomView';
import Availability from './pages/Availability';
import CleaningStatus from './pages/CleaningStatus';
import Owners from './pages/Owners';
import OwnerAdd from './pages/OwnerAdd';
import OwnerEdit from './pages/OwnerEdit';
import OwnerView from './pages/OwnerView';
import Users from './pages/Users';
import UserAdd from './pages/UserAdd';
import UserEdit from './pages/UserEdit';
import UserView from './pages/UserView';
import Expenses from './pages/Expenses';
import ExpenseAdd from './pages/ExpenseAdd';
import ExpenseEdit from './pages/ExpenseEdit';
import ExpenseView from './pages/ExpenseView';
import Reports from './pages/Reports';
import ChannelManager from './pages/ChannelManager';
import AuditLogs from './pages/AuditLogs';
import Settings from './pages/Settings';
import Login from './pages/Login';
import Profile from './pages/Profile';
import NotFound from './pages/NotFound';

// Property owner pages
import OwnerLogin from './pages/OwnerLogin';
import OwnerDashboard from './pages/OwnerDashboard';
import OwnerBookings from './pages/OwnerBookings';
import OwnerCleaningStatus from './pages/OwnerCleaningStatus';
import OwnerAvailability from './pages/OwnerAvailability';
import OwnerReports from './pages/OwnerReports';

// New pages for settings functionality
import PropertyAdd from './pages/PropertyAdd';
import PropertyEdit from './pages/PropertyEdit';
import RoomTypeAdd from './pages/RoomTypeAdd';
import RoomTypeEdit from './pages/RoomTypeEdit';
import EmailTemplateEdit from './pages/EmailTemplateEdit';
import SmsTemplateEdit from './pages/SmsTemplateEdit';
import UserRoleAdd from './pages/UserRoleAdd';
import UserRoleEdit from './pages/UserRoleEdit';

// Layout components
import { Header } from './components/layout/Header';
import { Sidebar } from './components/layout/Sidebar';
import { OwnerSidebar } from './components/layout/OwnerSidebar';
import { OwnerLayout } from './components/layout/OwnerLayout';

import { Toaster } from "@/components/ui/toaster";

function App() {
  return (
    <AuthProvider>
      <Routes>
        {/* Auth routes */}
        <Route path="/login" element={<Login />} />
        <Route path="/owner/login" element={<OwnerLogin />} />
        
        {/* Owner routes (protected) */}
        <Route path="/owner" element={
          <ProtectedRoute requiredRole={['owner']}>
            <NotifiedLayout>
              <OwnerLayout />
            </NotifiedLayout>
          </ProtectedRoute>
        }>
          <Route path="dashboard" element={<OwnerDashboard />} />
          <Route path="bookings" element={<OwnerBookings />} />
          <Route path="cleaning" element={<OwnerCleaningStatus />} />
          <Route path="availability" element={<OwnerAvailability />} />
          <Route path="reports" element={<OwnerReports />} />
        </Route>
        
        {/* Main app layout (staff routes) */}
        <Route path="/" element={
          <ProtectedRoute>
            <NotifiedLayout>
              <div className="grid h-screen grid-cols-[280px_1fr] overflow-hidden">
                <Sidebar />
                <div className="flex flex-col overflow-hidden">
                  <Header />
                  <main className="flex-1 overflow-y-auto bg-muted/20 p-6">
                    <Outlet />
                  </main>
                </div>
              </div>
            </NotifiedLayout>
          </ProtectedRoute>
        }>
          <Route index element={<Dashboard />} />
          <Route path="bookings" element={<Bookings />} />
          <Route path="bookings/add" element={<BookingAdd />} />
          <Route path="bookings/:id" element={<BookingView />} />
          <Route path="bookings/:id/edit" element={<BookingEdit />} />
          <Route path="rooms" element={<Rooms />} />
          <Route path="rooms/add" element={<RoomAdd />} />
          <Route path="rooms/:id" element={<RoomView />} />
          <Route path="rooms/:id/edit" element={<RoomEdit />} />
          <Route path="availability" element={<Availability />} />
          <Route path="cleaning" element={<CleaningStatus />} />
          <Route path="owners" element={<Owners />} />
          <Route path="owners/add" element={<OwnerAdd />} />
          <Route path="owners/:id" element={<OwnerView />} />
          <Route path="owners/:id/edit" element={<OwnerEdit />} />
          <Route path="users" element={<Users />} />
          <Route path="users/add" element={<UserAdd />} />
          <Route path="users/:id" element={<UserView />} />
          <Route path="users/:id/edit" element={<UserEdit />} />
          <Route path="expenses" element={<Expenses />} />
          <Route path="expenses/add" element={<ExpenseAdd />} />
          <Route path="expenses/:id" element={<ExpenseView />} />
          <Route path="expenses/:id/edit" element={<ExpenseEdit />} />
          <Route path="reports" element={<Reports />} />
          <Route path="channels" element={<ChannelManager />} />
          <Route path="audit-logs" element={<AuditLogs />} />
          <Route path="settings" element={<Settings />} />
          <Route path="profile" element={<Profile />} />
          
          {/* Settings routes */}
          <Route path="settings/properties/add" element={<PropertyAdd />} />
          <Route path="settings/properties/:id/edit" element={<PropertyEdit />} />
          <Route path="settings/room-types/add" element={<RoomTypeAdd />} />
          <Route path="settings/room-types/:id/edit" element={<RoomTypeEdit />} />
          <Route path="settings/email-templates/:id" element={<EmailTemplateEdit />} />
          <Route path="settings/sms-templates/:id" element={<SmsTemplateEdit />} />
          <Route path="settings/user-roles/add" element={<UserRoleAdd />} />
          <Route path="settings/user-roles/:id/edit" element={<UserRoleEdit />} />
        </Route>
        
        <Route path="*" element={<Navigate to="/login" replace />} />
      </Routes>
      <Toaster />
    </AuthProvider>
  );
}

// NotifiedLayout component wraps both staff and owner layouts with NotificationProvider
const NotifiedLayout = ({ children }: { children: React.ReactNode }) => {
  const { user } = useAuth();
  
  return (
    <NotificationProvider userId={user?.id}>
      {children}
    </NotificationProvider>
  );
};

const ProtectedRoute = ({ 
  children, 
  requiredRole 
}: { 
  children: JSX.Element,
  requiredRole?: string[]
}) => {
  const { isAuthenticated, user, isLoading } = useAuth();
  
  // Don't redirect until auth state is loaded from localStorage
  if (isLoading) {
    return <div className="flex items-center justify-center h-screen">
      <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
    </div>;
  }
  
  if (!isAuthenticated) {
    return <Navigate to="/login" />;
  }
  
  if (requiredRole && (!user || !requiredRole.includes(user.role))) {
    // Redirect staff to staff dashboard or owners to owner dashboard
    if (user.role === 'owner') {
      return <Navigate to="/owner/dashboard" />;
    } else {
      return <Navigate to="/" />;
    }
  }
  
  return children;
};

export default App;
