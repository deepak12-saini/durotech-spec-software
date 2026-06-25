import { StyleSheet, Text, View } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { colors } from '../constants/theme';

type IconName = keyof typeof Ionicons.glyphMap;

type Props = {
  icon: IconName;
  label: string;
  value: string;
  isLast?: boolean;
};

export function DetailField({ icon, label, value, isLast }: Props) {
  return (
    <View style={[styles.row, isLast && styles.rowLast]}>
      <View style={styles.iconWrap}>
        <Ionicons name={icon} size={18} color={colors.primary} />
      </View>
      <View style={styles.content}>
        <Text style={styles.label}>{label}</Text>
        <Text style={styles.value}>{value}</Text>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  row: {
    flexDirection: 'row',
    alignItems: 'flex-start',
    paddingHorizontal: 16,
    paddingVertical: 14,
    borderBottomWidth: 1,
    borderBottomColor: colors.inputBorder,
  },
  rowLast: {
    borderBottomWidth: 0,
  },
  iconWrap: {
    width: 36,
    height: 36,
    borderRadius: 10,
    backgroundColor: '#e8f4fc',
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 12,
    marginTop: 2,
  },
  content: {
    flex: 1,
  },
  label: {
    fontSize: 11,
    fontWeight: '600',
    letterSpacing: 1,
    color: colors.primary,
    textTransform: 'uppercase',
    marginBottom: 4,
  },
  value: {
    fontSize: 15,
    color: colors.textDark,
    lineHeight: 22,
  },
});
