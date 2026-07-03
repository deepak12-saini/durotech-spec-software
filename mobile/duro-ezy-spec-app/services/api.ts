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
    if (!token) {
      throw new ApiError('You are not signed in. Please sign in again.', 401);
    }
    headers.Authorization = `Bearer ${token}`;
    headers['X-Api-Token'] = token;
  }

  let response: globalThis.Response;
  try {
    response = await fetch(`${API_BASE_URL}${path}`, {
      method,
      headers,
      body: body !== undefined ? JSON.stringify(body) : undefined,
    });
  } catch {
    throw new ApiError(
      'Unable to reach the server. Check the API URL, CORS, or your network connection.',
      0,
    );
  }

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
