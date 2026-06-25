import { Pressable, StyleSheet, Text, View } from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { Ionicons } from '@expo/vector-icons';
import { router } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { MOCK_NEW_TRACK_NUMBER } from '../../data/mockRequest';
import { colors } from '../../constants/theme';
import { softShadow } from '../../constants/shadows';

export default function RequestSuccessScreen() {
  return (
    <SafeAreaView style={styles.container}>
      <StatusBar style="dark" />
      <View style={styles.content}>
        <View style={styles.iconWrap}>
          <View style={styles.iconInner}>
            <Ionicons name="checkmark" size={40} color={colors.primary} />
          </View>
        </View>

        <Text style={styles.title}>Request Submitted</Text>
        <Text style={styles.message}>
          Your specification request has been submitted. Our team will prepare
          the spec within 2 business days.
        </Text>

        <Pressable onPress={() => router.push('/(tabs)/specs')}>
          <Text style={styles.trackLink}>Track #{MOCK_NEW_TRACK_NUMBER}</Text>
        </Pressable>

        <Pressable
          style={styles.homeButton}
          onPress={() => router.replace('/(tabs)')}
        >
          <Text style={styles.homeButtonText}>Back to Home</Text>
        </Pressable>
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.white,
  },
  content: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    paddingHorizontal: 32,
    paddingBottom: 40,
  },
  iconWrap: {
    width: 96,
    height: 96,
    borderRadius: 48,
    backgroundColor: '#e8f4fc',
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 28,
  },
  iconInner: {
    width: 64,
    height: 64,
    borderRadius: 32,
    borderWidth: 2,
    borderColor: colors.primary,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: colors.white,
  },
  title: {
    fontSize: 26,
    fontWeight: '700',
    color: colors.textDark,
    marginBottom: 16,
    textAlign: 'center',
  },
  message: {
    fontSize: 15,
    lineHeight: 24,
    color: colors.textSecondary,
    textAlign: 'center',
    marginBottom: 24,
    maxWidth: 320,
  },
  trackLink: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.primary,
    textDecorationLine: 'underline',
    marginBottom: 36,
  },
  homeButton: {
    width: '100%',
    maxWidth: 320,
    backgroundColor: colors.primary,
    borderRadius: 14,
    minHeight: 54,
    alignItems: 'center',
    justifyContent: 'center',
    ...softShadow(colors.primary, 0.25),
  },
  homeButtonText: {
    fontSize: 17,
    fontWeight: '700',
    color: colors.white,
  },
});
