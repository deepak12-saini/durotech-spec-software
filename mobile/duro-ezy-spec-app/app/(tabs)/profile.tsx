import { useEffect, useState } from 'react';
import {
  ActivityIndicator,
  ScrollView,
  StyleSheet,
  Text,
  View,
} from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { router } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { ProfileMenuItem } from '../../components/ProfileMenuItem';
import { ProfileSection } from '../../components/ProfileSection';
import { getMe, getUserInitials, type AuthUser } from '../../services/auth';
import { fetchHomeData } from '../../services/specs';
import { colors } from '../../constants/theme';

export default function ProfileScreen() {
  const [user, setUser] = useState<AuthUser | null>(null);
  const [totalSpecs, setTotalSpecs] = useState('0');
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    let active = true;

    const load = async () => {
      try {
        const [me, home] = await Promise.all([getMe(), fetchHomeData()]);
        if (!active) {
          return;
        }

        setUser(me);
        setTotalSpecs(String(home.total));
        setError('');
      } catch (err) {
        if (!active) {
          return;
        }
        setUser(null);
        setTotalSpecs('0');
        setError(
          err instanceof Error
            ? err.message
            : 'Unable to load profile details right now.',
        );
      } finally {
        if (active) {
          setLoading(false);
        }
      }
    };

    load();

    return () => {
      active = false;
    };
  }, []);

  const displayName = user?.name ?? 'Employee';
  const email = user?.email ?? '';
  const initials = getUserInitials(displayName);

  return (
    <View style={styles.container}>
      <StatusBar style="light" />
      <View style={styles.header}>
        <SafeAreaView edges={['top']} style={styles.headerSafe}>
          {loading ? (
            <ActivityIndicator color={colors.white} />
          ) : (
            <>
              <View style={styles.avatar}>
                <Text style={styles.avatarText}>{initials}</Text>
              </View>
              <Text style={styles.name}>{displayName}</Text>
              <Text style={styles.role}>Employee</Text>
              {email ? <Text style={styles.email}>{email}</Text> : null}
            </>
          )}
        </SafeAreaView>
      </View>

      <ScrollView
        style={styles.body}
        contentContainerStyle={styles.bodyContent}
        showsVerticalScrollIndicator
      >
        {error ? <Text style={styles.errorText}>{error}</Text> : null}

        <ProfileSection title="ACCOUNT">
          <ProfileMenuItem
            icon="person-outline"
            title="Personal Details"
            subtitle="Name, email, phone"
          />
          <ProfileMenuItem
            icon="notifications-outline"
            title="Notifications"
            subtitle="Push & email alerts"
          />
          <ProfileMenuItem
            icon="location-outline"
            title="My Region"
            subtitle="VIC / SA / TAS"
            isLast
          />
        </ProfileSection>

        <ProfileSection title="SPECIFICATIONS">
          <ProfileMenuItem
            icon="document-text-outline"
            title="All Specifications"
            subtitle={`${totalSpecs} specs total`}
            onPress={() => router.push('/(tabs)/specs')}
          />
          <ProfileMenuItem
            icon="layers-outline"
            title="Saved Templates"
            subtitle="3 templates"
            isLast
          />
        </ProfileSection>

        <ProfileSection title="SUPPORT">
          <ProfileMenuItem
            icon="open-outline"
            title="Help & Documentation"
            subtitle="User guide & FAQs"
          />
          <ProfileMenuItem
            icon="mail-outline"
            title="Contact Support"
            subtitle="support@durotech.com.au"
            isLast
          />
        </ProfileSection>
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f7f9fb',
  },
  header: {
    backgroundColor: colors.primary,
    paddingBottom: 28,
  },
  headerSafe: {
    alignItems: 'center',
    paddingHorizontal: 24,
    paddingTop: 12,
    minHeight: 160,
    justifyContent: 'center',
  },
  avatar: {
    width: 72,
    height: 72,
    borderRadius: 36,
    backgroundColor: colors.white,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 14,
  },
  avatarText: {
    fontSize: 24,
    fontWeight: '700',
    color: colors.primary,
  },
  name: {
    fontSize: 22,
    fontWeight: '700',
    color: colors.white,
    marginBottom: 6,
    textAlign: 'center',
  },
  role: {
    fontSize: 14,
    color: colors.textMuted,
    marginBottom: 4,
    textAlign: 'center',
  },
  email: {
    fontSize: 14,
    color: colors.textMuted,
    textAlign: 'center',
  },
  body: {
    flex: 1,
  },
  bodyContent: {
    paddingHorizontal: 20,
    paddingTop: 24,
    paddingBottom: 24,
  },
  errorText: {
    fontSize: 14,
    color: '#c0392b',
    marginBottom: 16,
  },
});
