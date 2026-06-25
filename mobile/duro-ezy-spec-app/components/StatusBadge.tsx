import { StyleSheet, Text, View } from 'react-native';
import type { SpecStatus } from '../data/mockHome';

const statusStyles: Record<
  SpecStatus,
  { bg: string; text: string }
> = {
  Approved: { bg: '#e6f7ee', text: '#1f9d55' },
  Pending: { bg: '#fff4e5', text: '#e67e22' },
  Draft: { bg: '#eef2f6', text: '#8e99a8' },
};

type Props = {
  status: SpecStatus;
};

export function StatusBadge({ status }: Props) {
  const palette = statusStyles[status];

  return (
    <View style={[styles.badge, { backgroundColor: palette.bg }]}>
      <Text style={[styles.text, { color: palette.text }]}>{status}</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  badge: {
    borderRadius: 20,
    paddingHorizontal: 12,
    paddingVertical: 5,
  },
  text: {
    fontSize: 12,
    fontWeight: '600',
  },
});
