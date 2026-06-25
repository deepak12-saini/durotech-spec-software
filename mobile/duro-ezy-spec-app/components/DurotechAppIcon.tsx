import { StyleSheet, View } from 'react-native';
import { colors } from '../constants/theme';

type Props = {
  size?: number;
  variant?: 'splash' | 'brand';
};

export function DurotechAppIcon({ size = 56, variant = 'splash' }: Props) {
  const layerW = size * 0.78;
  const layerH = size * 0.2;
  const isBrand = variant === 'brand';

  return (
    <View style={[styles.stack, { width: size, height: size * 0.75 }]}>
      <View
        style={[
          styles.layer,
          isBrand ? styles.layerBackBrand : styles.layerBack,
          { width: layerW, height: layerH },
        ]}
      />
      <View
        style={[
          styles.layer,
          isBrand ? styles.layerMidBrand : styles.layerMid,
          { width: layerW, height: layerH },
        ]}
      />
      <View
        style={[
          styles.layer,
          isBrand ? styles.layerFrontBrand : styles.layerFront,
          { width: layerW, height: layerH },
        ]}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  stack: {
    alignItems: 'center',
    justifyContent: 'center',
  },
  layer: {
    position: 'absolute',
    borderRadius: 5,
    borderWidth: 1,
  },
  layerBack: {
    backgroundColor: '#5eb5e8',
    borderColor: 'rgba(255,255,255,0.35)',
    transform: [{ translateY: 16 }, { scaleX: 0.82 }, { rotate: '-6deg' }],
  },
  layerMid: {
    backgroundColor: colors.primaryLight,
    borderColor: 'rgba(255,255,255,0.35)',
    transform: [{ translateY: 4 }, { scaleX: 0.9 }, { rotate: '-3deg' }],
  },
  layerFront: {
    backgroundColor: colors.primary,
    borderColor: 'rgba(255,255,255,0.35)',
    transform: [{ translateY: -10 }, { rotate: '0deg' }],
  },
  layerBackBrand: {
    backgroundColor: 'rgba(255,255,255,0.45)',
    borderColor: 'rgba(255,255,255,0.25)',
    transform: [{ translateY: 16 }, { scaleX: 0.82 }, { rotate: '-6deg' }],
  },
  layerMidBrand: {
    backgroundColor: 'rgba(255,255,255,0.72)',
    borderColor: 'rgba(255,255,255,0.3)',
    transform: [{ translateY: 4 }, { scaleX: 0.9 }, { rotate: '-3deg' }],
  },
  layerFrontBrand: {
    backgroundColor: colors.white,
    borderColor: 'rgba(255,255,255,0.4)',
    transform: [{ translateY: -10 }, { rotate: '0deg' }],
  },
});
