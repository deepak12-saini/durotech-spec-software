import { useCallback, useEffect } from 'react';
import { ActivityIndicator, StyleSheet, Text, View } from 'react-native';
import { StatusBar } from 'expo-status-bar';
import Constants from 'expo-constants';
import { router } from 'expo-router';
import * as SplashScreen from 'expo-splash-screen';
import { SafeAreaView } from 'react-native-safe-area-context';
import { DurotechAppIcon } from '../components/DurotechAppIcon';
import { colors, spacing, typography } from '../constants/theme';
import { softShadow } from '../constants/shadows';
import { getMe } from '../services/auth';
import { getToken } from '../services/token';

const APP_VERSION = Constants.expoConfig?.version ?? '2.4.1';

export default function SplashScreenFragment() {
  const onLayout = useCallback(async () => {
    await SplashScreen.hideAsync();
  }, []);

  useEffect(() => {
    let active = true;

    const checkAuth = async () => {
      try {
        const token = await getToken();
        if (!active) {
          return;
        }

        if (token) {
          const user = await getMe();
          if (!active) {
            return;
          }

          if (user) {
            router.replace('/(tabs)');
            return;
          }
        }
      } catch {
        // Fall through to login on any auth check failure.
      }

      if (active) {
        router.replace('/login');
      }
    };

    checkAuth();

    return () => {
      active = false;
    };
  }, []);

  return (
    <SafeAreaView style={styles.container} onLayout={onLayout}>
      <StatusBar style="light" />
      <View style={styles.main}>
        <View style={styles.brandBlock}>
          <View style={styles.logoBox}>
            <DurotechAppIcon size={56} />
          </View>
          <Text style={styles.title}>DUROTECH</Text>
          <Text style={styles.subtitle}>WATERPROOFING SPECIFICATIONS</Text>
        </View>
        <View style={styles.loadingBlock}>
          <ActivityIndicator color={colors.white} size="small" />
          <Text style={styles.statusText}>Loading your workspace...</Text>
        </View>
      </View>
      <Text style={styles.footer}>
        v{APP_VERSION} - © 2024 Durotech Pty Ltd
      </Text>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.primary,
    alignItems: 'center',
  },
  main: {
    flex: 1,
    width: '100%',
    alignItems: 'center',
    justifyContent: 'center',
    paddingHorizontal: 24,
    paddingBottom: 32,
  },
  brandBlock: {
    alignItems: 'center',
    marginBottom: 72,
  },
  logoBox: {
    width: spacing.logoSize,
    height: spacing.logoSize,
    borderRadius: spacing.logoRadius,
    backgroundColor: colors.white,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 28,
    ...softShadow('#000000', 0.12),
  },
  title: {
    ...typography.title,
    color: colors.white,
    textTransform: 'uppercase',
    marginBottom: 10,
  },
  subtitle: {
    ...typography.subtitle,
    color: colors.textMuted,
    textTransform: 'uppercase',
    textAlign: 'center',
    maxWidth: 280,
  },
  loadingBlock: {
    alignItems: 'center',
    gap: 14,
  },
  statusText: {
    ...typography.status,
    color: colors.textMuted,
  },
  footer: {
    ...typography.footer,
    color: colors.textMuted,
    textAlign: 'center',
    paddingBottom: 12,
  },
});
