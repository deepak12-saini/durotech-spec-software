import {
  Pressable,
  StyleSheet,
  Text,
  TextInput,
  View,
  type TextInputProps,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { colors, typography } from '../constants/theme';

type IconName = keyof typeof Ionicons.glyphMap;

type Props = TextInputProps & {
  label: string;
  icon: IconName;
  rightIcon?: IconName;
  onRightIconPress?: () => void;
};

export function AuthTextField({
  label,
  icon,
  rightIcon,
  onRightIconPress,
  style,
  ...inputProps
}: Props) {
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
          autoCapitalize="none"
          autoCorrect={false}
          {...inputProps}
        />
        {rightIcon ? (
          <Pressable
            onPress={onRightIconPress}
            hitSlop={8}
            style={styles.rightIconButton}
          >
            <Ionicons name={rightIcon} size={20} color={colors.textSecondary} />
          </Pressable>
        ) : null}
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  field: {
    marginBottom: 20,
  },
  label: {
    ...typography.fieldLabel,
    color: colors.label,
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
  rightIconButton: {
    marginLeft: 8,
    padding: 4,
  },
});
