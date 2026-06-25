import { API_BASE_URL } from '../constants/config';
import { getToken } from './token';

export class ApiError extends Error {
  status: number;

  constructor(message: string, status: number) {
    super(message);
    this.name = 'ApiError';
    this.status = status;
  }
}

type RequestOptions = {
  method?: 'GET' | 'POST' | 'PUT' | 'DELETE';
  body?: unknown;
  auth?: boolean;
};

export async function apiRequest<T>(
  path: string,
  options: RequestOptions = {},
): Promise<T> {
  const { method = 'GET', body, auth = true } = options;
  const headers: Record<string, string> = {
    Accept: 'application/json',
  };

  if (body !== undefined) {
    headers['Content-Type'] = 'application/json';
  }

  if (auth) {
    const token = await getToken();
    if (token) {
      headers.Authorization = `Bearer ${token}`;
    }
  }

  const response = await fetch(`${API_BASE_URL}${path}`, {
    method,
    headers,
    body: body !== undefined ? JSON.stringify(body) : undefined,
  });

  const text = await response.text();
  let payload: Record<string, unknown> = {};

  if (text) {
    try {
      payload = JSON.parse(text) as Record<string, unknown>;
    } catch {
      throw new ApiError('Invalid server response.', response.status);
    }
  }

  if (!response.ok) {
    const message =
      (typeof payload.message === 'string' && payload.message) ||
      `Request failed (${response.status}).`;
    throw new ApiError(message, response.status);
  }

  return payload as T;
}
