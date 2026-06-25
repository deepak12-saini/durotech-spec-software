import { StyleSheet, Text, View } from 'react-native';
import { DurotechAppIcon } from './DurotechAppIcon';
import type { Spec } from '../data/mockSpecs';
import { getMockPdfScopeText } from '../data/mockPdf';
import { colors } from '../constants/theme';

type Props = {
  spec: Spec;
};

export function PdfDocumentPreview({ spec }: Props) {
  return (
    <View style={styles.page}>
      <View style={styles.banner}>
        <View style={styles.bannerText}>
          <Text style={styles.company}>DUROTECH PTY LTD</Text>
          <Text style={styles.docType}>Waterproofing Specification</Text>
        </View>
        <View style={styles.bannerLogo}>
          <DurotechAppIcon size={36} variant="brand" />
        </View>
      </View>

      <View style={styles.body}>
        <View style={styles.field}>
          <Text style={styles.fieldLabel}>SPECIFICATION NO.</Text>
          <Text style={styles.fieldValueBold}>{spec.trackNumber}</Text>
        </View>

        <View style={styles.field}>
          <Text style={styles.fieldLabel}>PROJECT</Text>
          <Text style={styles.fieldValue}>{spec.projectFull}</Text>
        </View>

        <Text style={styles.sectionTitle}>SECTION 1: SCOPE OF WORKS</Text>
        <Text style={styles.paragraph}>{getMockPdfScopeText(spec)}</Text>

        <Text style={styles.sectionTitle}>SECTION 2: PRODUCTS</Text>
        <Text style={styles.bullet}>• DuroShield BG-300 — below-grade membrane system</Text>
        <Text style={styles.bullet}>• DuroPrime EP-100 — epoxy primer for concrete substrates</Text>
        <Text style={styles.bullet}>• DuroSeal JT-50 — joint sealing compound</Text>

        <Text style={styles.sectionTitle}>SECTION 3: SUBSTRATE PREPARATION</Text>
        <Text style={styles.paragraph}>
          Concrete substrates must be clean, dry, and free from laitance, oil, and
          contaminants. Surface defects shall be repaired prior to membrane application.
          Moisture content must not exceed 5% prior to priming.
        </Text>

        <Text style={styles.sectionTitle}>SECTION 4: APPLICATION</Text>
        <Text style={styles.paragraph}>
          Apply primer at 0.3–0.5 L/m². Install membrane in two coats at right angles
          to a total dry film thickness of 2.0 mm minimum. Allow adequate curing between
          coats as per product data sheet.
        </Text>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  page: {
    backgroundColor: colors.white,
    borderRadius: 4,
    overflow: 'hidden',
    minHeight: 520,
  },
  banner: {
    backgroundColor: colors.primary,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: 20,
    paddingVertical: 18,
  },
  bannerText: {
    flex: 1,
    paddingRight: 12,
  },
  company: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.white,
    marginBottom: 4,
  },
  docType: {
    fontSize: 13,
    color: colors.textMuted,
  },
  bannerLogo: {
    width: 52,
    height: 52,
    borderRadius: 12,
    backgroundColor: colors.white,
    alignItems: 'center',
    justifyContent: 'center',
  },
  body: {
    padding: 20,
    paddingBottom: 28,
  },
  field: {
    marginBottom: 16,
  },
  fieldLabel: {
    fontSize: 11,
    fontWeight: '600',
    letterSpacing: 0.8,
    color: colors.textSecondary,
    marginBottom: 4,
  },
  fieldValueBold: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.textDark,
  },
  fieldValue: {
    fontSize: 15,
    color: colors.textDark,
    lineHeight: 22,
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '700',
    color: colors.primary,
    marginTop: 8,
    marginBottom: 8,
  },
  paragraph: {
    fontSize: 13,
    color: colors.textDark,
    lineHeight: 20,
    marginBottom: 12,
  },
  bullet: {
    fontSize: 13,
    color: colors.textDark,
    lineHeight: 20,
    marginBottom: 6,
    paddingLeft: 4,
  },
});
