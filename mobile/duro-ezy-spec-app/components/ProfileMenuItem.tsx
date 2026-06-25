import { Pressable, StyleSheet, Text, View } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { colors } from '../constants/theme';

type IconName = keyof typeof Ionicons.glyphMap;

type Props = {
  icon: IconName;
  title: string;
  subtitle: string;
  onPress?: () => void;
  isLast?: boolean;
};

export function ProfileMenuItem({
  icon,
  title,
  subtitle,
  onPress,
  isLast,
}: Props) {
  return (
    <Pressable
      style={({ pressed }) => [
        styles.row,
        !isLast && styles.rowBorder,
        pressed && styles.pressed,
      ]}
      onPress={onPress}
    >
      <View style={styles.iconWrap}>
        <Ionicons name={icon} size={20} color={colors.primary} />
      </View>
      <View style={styles.content}>
        <Text style={styles.title}>{title}</Text>
        <Text style={styles.subtitle}>{subtitle}</Text>
      </View>
      <Ionicons name="chevron-forward" size={18} color={colors.textSecondary} />
    </Pressable>
  );
}

const styles = StyleSheet.create({
  row: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 16,
    paddingVertical: 14,
    backgroundColor: colors.white,
  },
  rowBorder: {
    borderBottomWidth: 1,
    borderBottomColor: colors.inputBorder,
  },
  pressed: {
    opacity: 0.92,
  },
  iconWrap: {
    width: 42,
    height: 42,
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
  title: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.textDark,
    marginBottom: 2,
  },
  subtitle: {
    fontSize: 13,
    color: colors.textSecondary,
  },
});
