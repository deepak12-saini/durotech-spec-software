import { Pressable, StyleSheet, Text, View } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import type { RecentSpec } from '../data/mockHome';
import { StatusBadge } from './StatusBadge';
import { colors } from '../constants/theme';
import { softShadow } from '../constants/shadows';

type Props = {
  spec: RecentSpec;
  onPress?: () => void;
};

export function SpecListItem({ spec, onPress }: Props) {
  return (
    <Pressable
      style={({ pressed }) => [styles.card, pressed && styles.pressed]}
      onPress={onPress}
    >
      <View style={styles.iconWrap}>
        <Ionicons name="document-text-outline" size={22} color={colors.primary} />
      </View>
      <View style={styles.content}>
        <Text style={styles.trackNumber}>{spec.trackNumber}</Text>
        <Text style={styles.project} numberOfLines={1}>
          {spec.project}
        </Text>
      </View>
      <StatusBadge status={spec.status} />
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
    marginBottom: 10,
    borderWidth: 1,
    borderColor: colors.inputBorder,
    ...softShadow('#000000', 0.06, 2),
  },
  pressed: {
    opacity: 0.92,
  },
  iconWrap: {
    width: 42,
    height: 42,
    borderRadius: 10,
    backgroundColor: '#e8f4fc',
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 12,
  },
  content: {
    flex: 1,
    marginRight: 8,
  },
  trackNumber: {
    fontSize: 15,
    fontWeight: '700',
    color: colors.textDark,
    marginBottom: 2,
  },
  project: {
    fontSize: 13,
    color: colors.textSecondary,
  },
  chevron: {
    marginLeft: 6,
  },
});
