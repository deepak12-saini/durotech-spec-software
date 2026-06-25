import { Platform, type ViewStyle } from 'react-native';

export function softShadow(
  color = '#000000',
  opacity = 0.12,
  elevation = 4,
): ViewStyle {
  if (Platform.OS === 'web') {
    const hex = color.replace('#', '');
    const r = parseInt(hex.slice(0, 2), 16);
    const g = parseInt(hex.slice(2, 4), 16);
    const b = parseInt(hex.slice(4, 6), 16);

    return {
      boxShadow: `0px 4px 8px rgba(${r}, ${g}, ${b}, ${opacity})`,
    } as ViewStyle;
  }

  return {
    shadowColor: color,
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: opacity,
    shadowRadius: 8,
    elevation,
  };
}
