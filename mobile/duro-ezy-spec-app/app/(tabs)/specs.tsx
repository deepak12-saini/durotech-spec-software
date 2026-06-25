import { useCallback, useEffect, useMemo, useState } from 'react';
import {
  ActivityIndicator,
  FlatList,
  StyleSheet,
  Text,
  TextInput,
  View,
} from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { router } from 'expo-router';
import { Ionicons } from '@expo/vector-icons';
import { SafeAreaView } from 'react-native-safe-area-context';
import { SpecCard } from '../../components/SpecCard';
import { fetchSpecs, type SpecListItem } from '../../services/specs';
import { colors } from '../../constants/theme';

export default function SpecsScreen() {
  const [query, setQuery] = useState('');
  const [specs, setSpecs] = useState<SpecListItem[]>([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);

  const loadSpecs = useCallback(async (search: string) => {
    setLoading(true);
    try {
      const result = await fetchSpecs({ search, page: 1, limit: 100 });
      setSpecs(result.items);
      setTotal(result.meta.total);
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    const timer = setTimeout(() => {
      loadSpecs(query.trim());
    }, 300);

    return () => clearTimeout(timer);
  }, [loadSpecs, query]);

  const listData = useMemo(() => specs, [specs]);

  return (
    <View style={styles.container}>
      <StatusBar style="light" />
      <View style={styles.header}>
        <SafeAreaView edges={['top']} style={styles.headerSafe}>
          <View style={styles.titleRow}>
            <Text style={styles.title}>Specifications</Text>
            <View style={styles.totalPill}>
              <Text style={styles.totalText}>{total} total</Text>
            </View>
          </View>

          <View style={styles.searchRow}>
            <Ionicons
              name="search-outline"
              size={20}
              color={colors.textSecondary}
              style={styles.searchIcon}
            />
            <TextInput
              style={styles.searchInput}
              placeholder="Search by project or track #"
              placeholderTextColor={colors.textSecondary}
              value={query}
              onChangeText={setQuery}
              autoCapitalize="none"
              autoCorrect={false}
            />
          </View>
        </SafeAreaView>
      </View>

      {loading ? (
        <View style={styles.loaderWrap}>
          <ActivityIndicator color={colors.primary} size="large" />
        </View>
      ) : (
        <FlatList
          data={listData}
          keyExtractor={(item) => item.id}
          renderItem={({ item }) => (
            <SpecCard
              spec={{
                id: item.id,
                trackNumber: item.trackNumber,
                project: item.project,
                projectFull: item.project,
                client: item.client,
                address: '',
                email: '',
                specType: '',
                status: item.status,
                date: item.date,
              }}
              onPress={() => router.push(`/spec/${item.id}`)}
            />
          )}
          contentContainerStyle={styles.listContent}
          showsVerticalScrollIndicator
          ListEmptyComponent={
            <View style={styles.empty}>
              <Text style={styles.emptyText}>No specifications found</Text>
            </View>
          }
        />
      )}
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
    paddingBottom: 20,
  },
  headerSafe: {
    paddingHorizontal: 20,
  },
  titleRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginTop: 8,
    marginBottom: 18,
  },
  title: {
    fontSize: 26,
    fontWeight: '700',
    color: colors.white,
  },
  totalPill: {
    backgroundColor: 'rgba(255,255,255,0.2)',
    borderRadius: 20,
    paddingHorizontal: 12,
    paddingVertical: 6,
  },
  totalText: {
    fontSize: 13,
    fontWeight: '600',
    color: colors.white,
  },
  searchRow: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.white,
    borderRadius: 14,
    paddingHorizontal: 14,
    minHeight: 48,
  },
  searchIcon: {
    marginRight: 10,
  },
  searchInput: {
    flex: 1,
    fontSize: 15,
    color: colors.textDark,
    paddingVertical: 12,
  },
  loaderWrap: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  listContent: {
    paddingHorizontal: 20,
    paddingTop: 20,
    paddingBottom: 24,
  },
  empty: {
    paddingTop: 40,
    alignItems: 'center',
  },
  emptyText: {
    fontSize: 15,
    color: colors.textSecondary,
  },
});
