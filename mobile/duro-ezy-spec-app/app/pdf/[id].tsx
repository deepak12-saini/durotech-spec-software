import { useEffect, useState } from 'react';
import { Alert, Linking, Pressable, StyleSheet, Text, View } from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { Ionicons } from '@expo/vector-icons';
import { router, useLocalSearchParams } from 'expo-router';
import * as WebBrowser from 'expo-web-browser';
import { SafeAreaView } from 'react-native-safe-area-context';
import { USE_MOCK_API } from '../../constants/config';
import { PdfDocumentPreview } from '../../components/PdfDocumentPreview';
import { getPdfFilename } from '../../data/mockPdf';
import { fetchSpecById, fetchSpecPdf } from '../../services/specs';
import type { Spec } from '../../data/mockSpecs';
import { colors } from '../../constants/theme';

const viewerColors = {
  background: '#1e2a36',
  surface: '#2a3847',
  muted: '#9aa8b8',
};

export default function PdfViewerScreen() {
  const { id } = useLocalSearchParams<{ id: string }>();
  const [spec, setSpec] = useState<Spec | null>(null);
  const [pdfUrl, setPdfUrl] = useState<string | null>(null);
  const [filename, setFilename] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    let active = true;

    const load = async () => {
      if (!id) {
        setLoading(false);
        return;
      }

      const [specResult, pdfResult] = await Promise.all([
        fetchSpecById(id),
        fetchSpecPdf(id),
      ]);

      if (!active) {
        return;
      }

      setSpec(specResult);
      setPdfUrl(pdfResult?.url ?? null);
      setFilename(
        pdfResult?.filename ??
          (specResult ? getPdfFilename(specResult) : 'Specification.pdf'),
      );
      setLoading(false);
    };

    load();

    return () => {
      active = false;
    };
  }, [id]);

  if (loading) {
    return (
      <View style={styles.notFound}>
        <Text style={styles.notFoundText}>Loading PDF...</Text>
      </View>
    );
  }

  if (!spec) {
    return (
      <View style={styles.notFound}>
        <Text style={styles.notFoundText}>PDF not found</Text>
        <Pressable onPress={() => router.back()}>
          <Text style={styles.backLink}>Go back</Text>
        </Pressable>
      </View>
    );
  }

  const openPdf = async () => {
    if (USE_MOCK_API || !pdfUrl) {
      Alert.alert('Demo', 'Live PDF URL is not available in mock mode.');
      return;
    }

    try {
      await WebBrowser.openBrowserAsync(pdfUrl);
    } catch {
      await Linking.openURL(pdfUrl);
    }
  };

  const sharePdf = async () => {
    if (!pdfUrl) {
      Alert.alert('Unavailable', 'No PDF is attached to this specification.');
      return;
    }

    await Linking.openURL(pdfUrl);
  };

  return (
    <View style={styles.container}>
      <StatusBar style="light" />
      <SafeAreaView edges={['top']} style={styles.header}>
        <Pressable style={styles.iconButton} onPress={() => router.back()}>
          <Ionicons name="arrow-back" size={22} color={colors.white} />
        </Pressable>

        <View style={styles.headerCenter}>
          <Text style={styles.filename} numberOfLines={1}>
            {filename}
          </Text>
          <Text style={styles.pageInfo}>
            {pdfUrl ? 'Tap Open in Safari to view' : 'PDF not yet available'}
          </Text>
        </View>

        <View style={styles.headerActions}>
          <Pressable style={styles.iconButton} onPress={sharePdf}>
            <Ionicons name="share-outline" size={20} color={colors.white} />
          </Pressable>
          <Pressable style={styles.iconButton} onPress={openPdf}>
            <Ionicons name="download-outline" size={20} color={colors.white} />
          </Pressable>
        </View>
      </SafeAreaView>

      <View style={styles.previewWrap}>
        <PdfDocumentPreview spec={spec} />
      </View>

      <SafeAreaView edges={['bottom']} style={styles.footer}>
        <Pressable
          style={[styles.saveButton, !pdfUrl && styles.disabledButton]}
          onPress={openPdf}
          disabled={!pdfUrl}
        >
          <Ionicons name="download-outline" size={20} color={colors.white} />
          <Text style={styles.saveButtonText}>Save PDF</Text>
        </Pressable>

        <Pressable
          style={[styles.safariButton, !pdfUrl && styles.disabledButton]}
          onPress={openPdf}
          disabled={!pdfUrl}
        >
          <Ionicons name="open-outline" size={20} color={colors.white} />
          <Text style={styles.safariButtonText}>Open in Safari</Text>
        </Pressable>
      </SafeAreaView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: viewerColors.background,
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 16,
    paddingBottom: 12,
    gap: 10,
  },
  iconButton: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: viewerColors.surface,
    alignItems: 'center',
    justifyContent: 'center',
  },
  headerCenter: {
    flex: 1,
    alignItems: 'center',
    paddingHorizontal: 4,
  },
  filename: {
    fontSize: 15,
    fontWeight: '700',
    color: colors.white,
    marginBottom: 2,
  },
  pageInfo: {
    fontSize: 12,
    color: viewerColors.muted,
  },
  headerActions: {
    flexDirection: 'row',
    gap: 8,
  },
  previewWrap: {
    flex: 1,
    paddingHorizontal: 16,
    paddingVertical: 12,
  },
  footer: {
    flexDirection: 'row',
    gap: 12,
    paddingHorizontal: 16,
    paddingTop: 12,
    paddingBottom: 8,
    backgroundColor: viewerColors.background,
    borderTopWidth: 1,
    borderTopColor: viewerColors.surface,
  },
  saveButton: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    gap: 8,
    backgroundColor: colors.primary,
    borderRadius: 14,
    minHeight: 50,
  },
  safariButton: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    gap: 8,
    backgroundColor: viewerColors.surface,
    borderRadius: 14,
    minHeight: 50,
  },
  disabledButton: {
    opacity: 0.5,
  },
  saveButtonText: {
    fontSize: 15,
    fontWeight: '700',
    color: colors.white,
  },
  safariButtonText: {
    fontSize: 15,
    fontWeight: '700',
    color: colors.white,
  },
  notFound: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: viewerColors.background,
  },
  notFoundText: {
    fontSize: 16,
    color: viewerColors.muted,
    marginBottom: 12,
  },
  backLink: {
    fontSize: 15,
    fontWeight: '600',
    color: colors.primary,
  },
});
