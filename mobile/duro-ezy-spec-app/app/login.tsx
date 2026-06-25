import { useState } from 'react';
import {
  ActivityIndicator,
  KeyboardAvoidingView,
  Platform,
  Pressable,
  ScrollView,
  StyleSheet,
  Text,
  View,
} from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { router } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { AuthTextField } from '../components/AuthTextField';
import { DurotechAppIcon } from '../components/DurotechAppIcon';
import { colors, spacing, typography } from '../constants/theme';
import { softShadow } from '../constants/shadows';
import { ApiError } from '../services/api';
import { login } from '../services/auth';

export default function LoginScreen() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleSignIn = async () => {
    const trimmedUsername = username.trim();
    if (!trimmedUsername || !password) {
      setError('Please enter your username and password.');
      return;
    }

    setLoading(true);
    setError('');

    try {
      await login(trimmedUsername, password);
      router.replace('/(tabs)');
    } catch (err) {
      if (err instanceof ApiError) {
        setError(err.message);
      } else {
        setError('Unable to sign in. Check your connection and try again.');
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar style="dark" />
      <KeyboardAvoidingView
        style={styles.flex}
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      >
        <ScrollView
          contentContainerStyle={styles.scroll}
          keyboardShouldPersistTaps="handled"
          showsVerticalScrollIndicator={false}
        >
          <View style={styles.brandHeader}>
            <View style={styles.logoBox}>
              <DurotechAppIcon size={44} variant="brand" />
            </View>
            <Text style={styles.brandTitle}>DUROTECH</Text>
            <Text style={styles.brandSubtitle}>
              WATERPROOFING SPECIFICATIONS
            </Text>
          </View>

          <View style={styles.formSection}>
            <Text style={styles.welcome}>Welcome back</Text>
            <Text style={styles.signInHint}>Sign in to your account</Text>

            <View style={styles.form}>
              <AuthTextField
                label="Username"
                icon="person-outline"
                placeholder="your.username"
                keyboardType="default"
                autoCapitalize="none"
                autoCorrect={false}
                textContentType="username"
                value={username}
                onChangeText={setUsername}
              />

              <AuthTextField
                label="Password"
                icon="lock-closed-outline"
                placeholder="••••••••"
                secureTextEntry={!showPassword}
                textContentType="password"
                value={password}
                onChangeText={setPassword}
                rightIcon={showPassword ? 'eye-off-outline' : 'eye-outline'}
                onRightIconPress={() => setShowPassword((prev) => !prev)}
              />

              {error ? <Text style={styles.errorText}>{error}</Text> : null}

              <Pressable style={styles.forgotRow}>
                <Text style={styles.forgotText}>Forgot password?</Text>
              </Pressable>

              <Pressable
                style={[styles.signInButton, loading && styles.signInDisabled]}
                onPress={handleSignIn}
                disabled={loading}
              >
                {loading ? (
                  <ActivityIndicator color={colors.white} />
                ) : (
                  <Text style={styles.signInText}>Sign In</Text>
                )}
              </Pressable>
            </View>
          </View>

          <View style={styles.dividerRow}>
            <View style={styles.dividerLine} />
            <Text style={styles.dividerText}>or</Text>
            <View style={styles.dividerLine} />
          </View>
        </ScrollView>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.white,
  },
  flex: {
    flex: 1,
  },
  scroll: {
    flexGrow: 1,
    paddingHorizontal: 28,
    paddingTop: 24,
    paddingBottom: 32,
  },
  brandHeader: {
    alignItems: 'center',
    marginBottom: 36,
  },
  logoBox: {
    width: spacing.brandLogoSize,
    height: spacing.brandLogoSize,
    borderRadius: 18,
    backgroundColor: colors.primary,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 16,
  },
  brandTitle: {
    ...typography.brandTitle,
    color: colors.textDark,
    textTransform: 'uppercase',
    marginBottom: 6,
  },
  brandSubtitle: {
    ...typography.subtitle,
    color: colors.textSecondary,
    textTransform: 'uppercase',
    textAlign: 'center',
  },
  formSection: {
    width: '100%',
  },
  welcome: {
    ...typography.welcome,
    color: colors.textDark,
    marginBottom: 6,
  },
  signInHint: {
    ...typography.status,
    color: colors.textSecondary,
    marginBottom: 28,
  },
  form: {
    width: '100%',
  },
  errorText: {
    color: '#c0392b',
    fontSize: 14,
    marginBottom: 12,
  },
  forgotRow: {
    alignSelf: 'flex-end',
    marginTop: -4,
    marginBottom: 24,
  },
  forgotText: {
    fontSize: 14,
    fontWeight: '500',
    color: colors.primary,
  },
  signInButton: {
    backgroundColor: colors.primary,
    borderRadius: 14,
    minHeight: 54,
    alignItems: 'center',
    justifyContent: 'center',
    ...softShadow(colors.primary, 0.25),
  },
  signInDisabled: {
    opacity: 0.75,
  },
  signInText: {
    fontSize: 17,
    fontWeight: '700',
    color: colors.white,
  },
  dividerRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginTop: 32,
    gap: 12,
  },
  dividerLine: {
    flex: 1,
    height: 1,
    backgroundColor: colors.divider,
  },
  dividerText: {
    fontSize: 14,
    color: colors.textSecondary,
  },
});
