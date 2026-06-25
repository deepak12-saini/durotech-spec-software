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
import { Ionicons } from '@expo/vector-icons';
import { router, useLocalSearchParams } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { DetailField } from '../../components/DetailField';
import { DetailSection } from '../../components/DetailSection';
import { StatusBadge } from '../../components/StatusBadge';
import { fetchSpecById } from '../../services/specs';
import type { Spec } from '../../data/mockSpecs';
import { colors } from '../../constants/theme';
import { softShadow } from '../../constants/shadows';

export default function SpecDetailScreen() {
  const { id } = useLocalSearchParams<{ id: string }>();
  const [spec, setSpec] = useState<Spec | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    let active = true;

    const load = async () => {
      if (!id) {
        setLoading(false);
        return;
      }

      const result = await fetchSpecById(id);
      if (active) {
        setSpec(result);
        setLoading(false);
      }
    };

    load();

    return () => {
      active = false;
    };
  }, [id]);

  if (loading) {
    return (
      <View style={styles.loader}>
        <ActivityIndicator color={colors.primary} size="large" />
      </View>
    );
  }

  if (!spec) {
    return (
      <View style={styles.notFound}>
        <Text style={styles.notFoundText}>Specification not found</Text>
        <Pressable onPress={() => router.back()}>
          <Text style={styles.backLink}>Go back</Text>
        </Pressable>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <StatusBar style="light" />
      <View style={styles.header}>
        <SafeAreaView edges={['top']} style={styles.headerSafe}>
          <Pressable style={styles.backButton} onPress={() => router.back()}>
            <Ionicons name="arrow-back" size={22} color={colors.white} />
          </Pressable>

          <View style={styles.headerContent}>
            <View style={styles.titleBlock}>
              <Text style={styles.headerLabel}>Specification</Text>
              <Text style={styles.trackNumber}>{spec.trackNumber}</Text>
            </View>
            <StatusBadge status={spec.status} />
          </View>
        </SafeAreaView>
      </View>

      <ScrollView
        style={styles.body}
        contentContainerStyle={styles.bodyContent}
        showsVerticalScrollIndicator
      >
        <DetailSection title="PROJECT DETAILS">
          <DetailField
            icon="business-outline"
            label="Client"
            value={spec.client}
          />
          <DetailField
            icon="grid-outline"
            label="Project"
            value={spec.projectFull}
          />
          <DetailField
            icon="location-outline"
            label="Address"
            value={spec.address}
          />
          <DetailField
            icon="mail-outline"
            label="Email"
            value={spec.email}
            isLast
          />
        </DetailSection>

        <DetailSection title="SPECIFICATION">
          <DetailField
            icon="layers-outline"
            label="Type"
            value={spec.specType}
            isLast
          />
        </DetailSection>
      </ScrollView>

      <SafeAreaView edges={['bottom']} style={styles.footer}>
        <Pressable
          style={styles.pdfButton}
          onPress={() => router.push(`/pdf/${spec.id}`)}
        >
          <Ionicons name="download-outline" size={22} color={colors.white} />
          <Text style={styles.pdfButtonText}>View PDF</Text>
        </Pressable>
      </SafeAreaView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f7f9fb',
  },
  loader: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#f7f9fb',
  },
  header: {
    backgroundColor: colors.primary,
    paddingBottom: 20,
  },
  headerSafe: {
    paddingHorizontal: 20,
  },
  backButton: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: 'rgba(255,255,255,0.18)',
    alignItems: 'center',
    justifyContent: 'center',
    marginTop: 8,
    marginBottom: 16,
  },
  headerContent: {
    flexDirection: 'row',
    alignItems: 'flex-start',
    justifyContent: 'space-between',
    gap: 12,
  },
  titleBlock: {
    flex: 1,
  },
  headerLabel: {
    fontSize: 14,
    color: colors.textMuted,
    marginBottom: 4,
  },
  trackNumber: {
    fontSize: 26,
    fontWeight: '700',
    color: colors.white,
  },
  body: {
    flex: 1,
  },
  bodyContent: {
    padding: 20,
    paddingBottom: 24,
  },
  footer: {
    backgroundColor: colors.white,
    borderTopWidth: 1,
    borderTopColor: colors.divider,
    paddingHorizontal: 20,
    paddingTop: 12,
    paddingBottom: 8,
  },
  pdfButton: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    gap: 10,
    backgroundColor: colors.primary,
    borderRadius: 14,
    minHeight: 54,
    ...softShadow(colors.primary, 0.25),
  },
  pdfButtonText: {
    fontSize: 17,
    fontWeight: '700',
    color: colors.white,
  },
  notFound: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: colors.white,
  },
  notFoundText: {
    fontSize: 16,
    color: colors.textSecondary,
    marginBottom: 12,
  },
  backLink: {
    fontSize: 15,
    fontWeight: '600',
    color: colors.primary,
  },
});
