import type { ReactNode } from 'react';
import { StyleSheet, Text, View } from 'react-native';
import { colors, typography } from '../constants/theme';
import { softShadow } from '../constants/shadows';

type Props = {
  title: string;
  children: ReactNode;
};

export function ProfileSection({ title, children }: Props) {
  return (
    <View style={styles.section}>
      <Text style={styles.sectionTitle}>{title}</Text>
      <View style={styles.card}>{children}</View>
    </View>
  );
}

const styles = StyleSheet.create({
  section: {
    marginBottom: 24,
  },
  sectionTitle: {
    ...typography.fieldLabel,
    color: colors.label,
    marginBottom: 10,
    paddingHorizontal: 4,
  },
  card: {
    backgroundColor: colors.white,
    borderRadius: 14,
    borderWidth: 1,
    borderColor: colors.inputBorder,
    overflow: 'hidden',
    ...softShadow('#000000', 0.06, 2),
  },
});
