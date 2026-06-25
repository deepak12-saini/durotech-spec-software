/** Set to true to use local mock data instead of the live API. */
export const USE_MOCK_API = false;

export const API_BASE_URL =
  process.env.EXPO_PUBLIC_API_URL ?? 'http://192.168.29.188/cake3app';

export const TOKEN_STORAGE_KEY = 'duro_ezy_spec_api_token';
