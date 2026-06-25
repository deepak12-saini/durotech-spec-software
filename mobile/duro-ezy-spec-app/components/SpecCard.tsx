import { Pressable, StyleSheet, Text, View } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import type { Spec } from '../data/mockSpecs';
import { StatusBadge } from './StatusBadge';
import { colors } from '../constants/theme';
import { softShadow } from '../constants/shadows';

type Props = {
  spec: Spec;
  onPress?: () => void;
};

export function SpecCard({ spec, onPress }: Props) {
  return (
    <Pressable
      style={({ pressed }) => [styles.card, pressed && styles.pressed]}
      onPress={onPress}
    >
      <View style={styles.iconWrap}>
        <Ionicons name="document-text-outline" size={22} color={colors.primary} />
      </View>

      <View style={styles.content}>
        <View style={styles.topRow}>
          <Text style={styles.trackNumber}>{spec.trackNumber}</Text>
          <StatusBadge status={spec.status} />
        </View>
        <Text style={styles.project} numberOfLines={1}>
          {spec.project}
        </Text>
        <View style={styles.dateRow}>
          <Ionicons
            name="calendar-outline"
            size={14}
            color={colors.textSecondary}
          />
          <Text style={styles.date}>{spec.date}</Text>
        </View>
      </View>

      <Ionicons
        name="chevron-forward"
        size={18}
        color={colors.textSecondary}
        style={styles.chevron}
      />
    </Pressable>
  );
}

const styles = StyleSheet.create({
  card: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.white,
    borderRadius: 14,
    padding: 14,
    marginBottom: 12,
    borderWidth: 1,
    borderColor: colors.inputBorder,
    ...softShadow('#000000', 0.08, 3),
  },
  pressed: {
    opacity: 0.92,
  },
  iconWrap: {
    width: 44,
    height: 44,
    borderRadius: 12,
    backgroundColor: '#e8f4fc',
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 12,
  },
  content: {
    flex: 1,
    marginRight: 8,
  },
  topRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 4,
    gap: 8,
  },
  trackNumber: {
    fontSize: 13,
    fontWeight: '500',
    color: colors.textSecondary,
    flex: 1,
  },
  project: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.textDark,
    marginBottom: 6,
  },
  dateRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
  },
  date: {
    fontSize: 13,
    color: colors.textSecondary,
  },
  chevron: {
    marginLeft: 4,
  },
});
