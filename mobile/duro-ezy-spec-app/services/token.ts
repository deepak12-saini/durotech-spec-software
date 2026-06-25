import * as SecureStore from 'expo-secure-store';
import { Platform } from 'react-native';
import { TOKEN_STORAGE_KEY } from '../constants/config';

const memoryToken: { value: string | null } = { value: null };

export async function getToken(): Promise<string | null> {
  if (memoryToken.value) {
    return memoryToken.value;
  }

  if (Platform.OS === 'web') {
    memoryToken.value = localStorage.getItem(TOKEN_STORAGE_KEY);
    return memoryToken.value;
  }

  memoryToken.value = await SecureStore.getItemAsync(TOKEN_STORAGE_KEY);
  return memoryToken.value;
}

export async function setToken(token: string | null): Promise<void> {
  memoryToken.value = token;

  if (Platform.OS === 'web') {
    if (token) {
      localStorage.setItem(TOKEN_STORAGE_KEY, token);
    } else {
      localStorage.removeItem(TOKEN_STORAGE_KEY);
    }
    return;
  }

  if (token) {
    await SecureStore.setItemAsync(TOKEN_STORAGE_KEY, token);
  } else {
    await SecureStore.deleteItemAsync(TOKEN_STORAGE_KEY);
  }
}
