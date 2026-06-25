import { StyleSheet, Text, TextInput, View, type TextInputProps } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { colors, typography } from '../constants/theme';

type IconName = keyof typeof Ionicons.glyphMap;

type Props = TextInputProps & {
  label: string;
  icon: IconName;
};

export function FormTextField({ label, icon, style, ...inputProps }: Props) {
  return (
    <View style={styles.field}>
      <Text style={styles.label}>{label}</Text>
      <View style={styles.inputRow}>
        <Ionicons
          name={icon}
          size={18}
          color={colors.textSecondary}
          style={styles.leftIcon}
        />
        <TextInput
          style={[styles.input, style]}
          placeholderTextColor={colors.textSecondary}
          {...inputProps}
        />
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  field: {
    marginBottom: 18,
  },
  label: {
    ...typography.fieldLabel,
    color: colors.primary,
    textTransform: 'uppercase',
    marginBottom: 8,
  },
  inputRow: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.inputBg,
    borderRadius: 12,
    borderWidth: 1,
    borderColor: colors.inputBorder,
    minHeight: 52,
    paddingHorizontal: 14,
  },
  leftIcon: {
    marginRight: 10,
  },
  input: {
    flex: 1,
    fontSize: 15,
    color: colors.textDark,
    paddingVertical: 14,
  },
});
