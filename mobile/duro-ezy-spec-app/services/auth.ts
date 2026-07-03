import { ApiError, apiRequest } from './api';
import { getToken, setToken } from './token';

export type AuthUser = {
  id: number;
  name: string;
  username: string;
  email: string;
  role: string;
};

type LoginResponse = {
  success: boolean;
  token: string;
  user: AuthUser;
};

type MeResponse = {
  success: boolean;
  user: AuthUser;
};

export async function login(
  username: string,
  password: string,
): Promise<AuthUser> {
  const response = await apiRequest<LoginResponse>('/api/v1/auth/login.json', {
    method: 'POST',
    auth: false,
    body: { username, password },
  });

  await setToken(response.token);
  return response.user;
}

export async function logout(): Promise<void> {
  try {
    await apiRequest('/api/v1/auth/logout.json', { method: 'POST' });
  } catch {
    // Clear local session even if the server call fails.
  }

  await setToken(null);
}

export async function getMe(): Promise<AuthUser | null> {
  const token = await getToken();
  if (!token) {
    return null;
  }

  try {
    const response = await apiRequest<MeResponse>('/api/v1/auth/me.json');
    return response.user;
  } catch (err) {
    if (
      err instanceof ApiError &&
      err.status === 401 &&
      err.message.toLowerCase().includes('invalid or expired token')
    ) {
      await setToken(null);
    }
    return null;
  }
}

export function getUserInitials(name: string): string {
  const parts = name.trim().split(/\s+/).filter(Boolean);
  if (parts.length === 0) {
    return '?';
  }
  if (parts.length === 1) {
    return parts[0].slice(0, 2).toUpperCase();
  }
  return `${parts[0][0]}${parts[parts.length - 1][0]}`.toUpperCase();
}

export function getGreeting(): string {
  const hour = new Date().getHours();
  if (hour < 12) {
    return 'Good morning,';
  }
  if (hour < 17) {
    return 'Good afternoon,';
  }
  return 'Good evening,';
}
