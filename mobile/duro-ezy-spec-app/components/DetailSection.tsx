import type { ReactNode } from 'react';
import { StyleSheet, Text, View } from 'react-native';
import { colors } from '../constants/theme';

type Props = {
  title: string;
  children: ReactNode;
};

export function DetailSection({ title, children }: Props) {
  return (
    <View style={styles.card}>
      <View style={styles.header}>
        <Text style={styles.headerText}>{title}</Text>
      </View>
      <View style={styles.body}>{children}</View>
    </View>
  );
}

const styles = StyleSheet.create({
  card: {
    backgroundColor: colors.white,
    borderRadius: 14,
    borderWidth: 1,
    borderColor: colors.inputBorder,
    overflow: 'hidden',
    marginBottom: 16,
  },
  header: {
    backgroundColor: '#e8f4fc',
    paddingHorizontal: 16,
    paddingVertical: 12,
  },
  headerText: {
    fontSize: 12,
    fontWeight: '700',
    letterSpacing: 1.2,
    color: colors.primary,
  },
  body: {
    backgroundColor: colors.white,
  },
});
