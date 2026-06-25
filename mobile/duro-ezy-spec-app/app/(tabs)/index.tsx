import { useEffect, useState } from 'react';
import {
  ActivityIndicator,
  Pressable,
  ScrollView,
  StyleSheet,
  Text,
  View,
} from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { router } from 'expo-router';
import { Ionicons } from '@expo/vector-icons';
import { SafeAreaView } from 'react-native-safe-area-context';
import { SpecListItem } from '../../components/SpecListItem';
import { getGreeting, getMe, getUserInitials, type AuthUser } from '../../services/auth';
import { fetchHomeData } from '../../services/specs';
import { colors, typography } from '../../constants/theme';
import { softShadow } from '../../constants/shadows';

export default function HomeScreen() {
  const [user, setUser] = useState<AuthUser | null>(null);
  const [stats, setStats] = useState<{ value: string; label: string }[]>([]);
  const [recentSpecs, setRecentSpecs] = useState<
    Awaited<ReturnType<typeof fetchHomeData>>['recentSpecs']
  >([]);
  const [totalSpecs, setTotalSpecs] = useState(0);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    let active = true;

    const load = async () => {
      try {
        const [me, home] = await Promise.all([getMe(), fetchHomeData()]);
        if (!active) {
          return;
        }

        setUser(me);
        setStats(home.stats);
        setRecentSpecs(home.recentSpecs);
        setTotalSpecs(home.total);
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
  const initials = getUserInitials(displayName);

  return (
    <View style={styles.container}>
      <StatusBar style="light" />
      <View style={styles.header}>
        <SafeAreaView edges={['top']} style={styles.headerSafe}>
          <View style={styles.headerTop}>
            <View style={styles.greetingBlock}>
              <Text style={styles.greeting}>{getGreeting()}</Text>
              <Text style={styles.userName}>{displayName}</Text>
            </View>
            <View style={styles.headerActions}>
              <Pressable style={styles.iconButton}>
                <Ionicons
                  name="notifications-outline"
                  size={22}
                  color={colors.white}
                />
              </Pressable>
              <View style={styles.avatar}>
                <Text style={styles.avatarText}>{initials}</Text>
              </View>
            </View>
          </View>
          <View style={styles.statsRow}>
            {loading ? (
              <ActivityIndicator color={colors.white} style={styles.statsLoader} />
            ) : (
              stats.map((stat) => (
                <View key={stat.label} style={styles.statCard}>
                  <Text style={styles.statValue}>{stat.value}</Text>
                  <Text style={styles.statLabel}>{stat.label}</Text>
                </View>
              ))
            )}
          </View>
        </SafeAreaView>
      </View>

      <ScrollView
        style={styles.body}
        contentContainerStyle={styles.bodyContent}
        showsVerticalScrollIndicator={false}
      >
        <Text style={styles.sectionTitle}>QUICK ACTIONS</Text>
        <View style={styles.quickActionsRow}>
          <Pressable
            style={styles.quickCardLight}
            onPress={() => router.push('/(tabs)/specs')}
          >
            <View style={styles.quickIconLight}>
              <Ionicons
                name="document-text-outline"
                size={26}
                color={colors.primary}
              />
            </View>
            <Text style={styles.quickTitleDark}>My Specs</Text>
            <Text style={styles.quickSubtitleDark}>
              {totalSpecs} specifications
            </Text>
          </Pressable>

          <Pressable
            style={styles.quickCardPrimary}
            onPress={() => router.push('/(tabs)/new')}
          >
            <View style={styles.quickIconPrimary}>
              <Ionicons name="add" size={28} color={colors.primary} />
            </View>
            <Text style={styles.quickTitleLight}>New Request</Text>
            <Text style={styles.quickSubtitleLight}>Submit a spec</Text>
          </Pressable>
        </View>

        <View style={styles.recentHeader}>
          <Text style={styles.recentSectionTitle}>RECENT SPECS</Text>
          <Pressable onPress={() => router.push('/(tabs)/specs')}>
            <Text style={styles.seeAll}>See all</Text>
          </Pressable>
        </View>

        {loading ? (
          <ActivityIndicator color={colors.primary} style={styles.listLoader} />
        ) : recentSpecs.length === 0 ? (
          <Text style={styles.emptyText}>No specifications yet.</Text>
        ) : (
          recentSpecs.map((spec) => (
            <SpecListItem
              key={spec.id}
              spec={{
                id: spec.id,
                trackNumber: spec.trackNumber,
                project: spec.project,
                status: spec.status,
              }}
              onPress={() => router.push(`/spec/${spec.id}`)}
            />
          ))
        )}
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.white,
  },
  header: {
    backgroundColor: colors.primary,
    paddingBottom: 22,
  },
  headerSafe: {
    paddingHorizontal: 20,
  },
  headerTop: {
    flexDirection: 'row',
    alignItems: 'flex-start',
    justifyContent: 'space-between',
    marginBottom: 22,
    marginTop: 8,
  },
  greetingBlock: {
    flex: 1,
    paddingRight: 12,
  },
  greeting: {
    fontSize: 14,
    color: colors.textMuted,
    marginBottom: 4,
  },
  userName: {
    fontSize: 24,
    fontWeight: '700',
    color: colors.white,
  },
  headerActions: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
  },
  iconButton: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: 'rgba(255,255,255,0.18)',
    alignItems: 'center',
    justifyContent: 'center',
  },
  avatar: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: colors.white,
    alignItems: 'center',
    justifyContent: 'center',
  },
  avatarText: {
    fontSize: 14,
    fontWeight: '700',
    color: colors.primary,
  },
  statsRow: {
    flexDirection: 'row',
    gap: 10,
    minHeight: 72,
    alignItems: 'center',
  },
  statsLoader: {
    flex: 1,
  },
  statCard: {
    flex: 1,
    backgroundColor: 'rgba(255,255,255,0.18)',
    borderRadius: 14,
    paddingVertical: 14,
    paddingHorizontal: 8,
    alignItems: 'center',
  },
  statValue: {
    fontSize: 22,
    fontWeight: '700',
    color: colors.white,
    marginBottom: 4,
  },
  statLabel: {
    fontSize: 11,
    color: colors.textMuted,
    textAlign: 'center',
  },
  body: {
    flex: 1,
    backgroundColor: colors.white,
  },
  bodyContent: {
    paddingHorizontal: 20,
    paddingTop: 24,
    paddingBottom: 24,
  },
  sectionTitle: {
    ...typography.fieldLabel,
    color: colors.label,
    marginBottom: 14,
  },
  quickActionsRow: {
    flexDirection: 'row',
    gap: 12,
    marginBottom: 28,
  },
  quickCardLight: {
    flex: 1,
    backgroundColor: colors.white,
    borderRadius: 16,
    padding: 16,
    minHeight: 148,
    borderWidth: 1,
    borderColor: colors.inputBorder,
    ...softShadow('#000000', 0.08, 3),
  },
  quickCardPrimary: {
    flex: 1,
    backgroundColor: colors.primary,
    borderRadius: 16,
    padding: 16,
    minHeight: 148,
    ...softShadow(colors.primary, 0.3, 4),
  },
  quickIconLight: {
    width: 48,
    height: 48,
    borderRadius: 12,
    backgroundColor: '#e8f4fc',
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 14,
  },
  quickIconPrimary: {
    width: 48,
    height: 48,
    borderRadius: 24,
    backgroundColor: colors.white,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 14,
  },
  quickTitleDark: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.textDark,
    marginBottom: 4,
  },
  quickSubtitleDark: {
    fontSize: 13,
    color: colors.textSecondary,
  },
  quickTitleLight: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.white,
    marginBottom: 4,
  },
  quickSubtitleLight: {
    fontSize: 13,
    color: colors.textMuted,
  },
  recentHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 14,
  },
  recentSectionTitle: {
    ...typography.fieldLabel,
    color: colors.label,
  },
  seeAll: {
    fontSize: 14,
    fontWeight: '600',
    color: colors.primary,
  },
  listLoader: {
    marginTop: 12,
  },
  emptyText: {
    fontSize: 15,
    color: colors.textSecondary,
  },
});
