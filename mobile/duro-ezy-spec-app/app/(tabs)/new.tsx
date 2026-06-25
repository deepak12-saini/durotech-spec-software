import { useState } from 'react';
import {
  KeyboardAvoidingView,
  Platform,
  Pressable,
  ScrollView,
  StyleSheet,
  Text,
  View,
} from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { Ionicons } from '@expo/vector-icons';
import { router } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { DetailSection } from '../../components/DetailSection';
import { FormTextField } from '../../components/FormTextField';
import { colors } from '../../constants/theme';
import { softShadow } from '../../constants/shadows';

export default function NewRequestScreen() {
  const [clientName, setClientName] = useState('');
  const [projectName, setProjectName] = useState('');
  const [siteAddress, setSiteAddress] = useState('');
  const [contactEmail, setContactEmail] = useState('');
  const [contactPhone, setContactPhone] = useState('');

  const handleSubmit = () => {
    router.push('/request/success');
  };

  return (
    <View style={styles.container}>
      <StatusBar style="light" />
      <View style={styles.header}>
        <SafeAreaView edges={['top']} style={styles.headerSafe}>
          <Pressable
            style={styles.backButton}
            onPress={() => router.push('/(tabs)')}
          >
            <Ionicons name="arrow-back" size={22} color={colors.white} />
          </Pressable>
          <Text style={styles.headerTitle}>New Spec Request</Text>
        </SafeAreaView>
      </View>

      <KeyboardAvoidingView
        style={styles.flex}
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      >
        <ScrollView
          style={styles.body}
          contentContainerStyle={styles.bodyContent}
          keyboardShouldPersistTaps="handled"
          showsVerticalScrollIndicator
        >
          <DetailSection title="PROJECT INFORMATION">
            <View style={styles.form}>
              <FormTextField
                label="Client Name"
                icon="business-outline"
                placeholder="e.g. Riverside Dev Group"
                value={clientName}
                onChangeText={setClientName}
              />
              <FormTextField
                label="Project Name"
                icon="grid-outline"
                placeholder="e.g. Riverside Commercial"
                value={projectName}
                onChangeText={setProjectName}
              />
              <FormTextField
                label="Site Address"
                icon="location-outline"
                placeholder="Street, Suburb, State"
                value={siteAddress}
                onChangeText={setSiteAddress}
              />
              <FormTextField
                label="Contact Email"
                icon="mail-outline"
                placeholder="contact@company.com"
                keyboardType="email-address"
                autoCapitalize="none"
                autoCorrect={false}
                value={contactEmail}
                onChangeText={setContactEmail}
              />
              <FormTextField
                label="Contact Phone"
                icon="call-outline"
                placeholder="e.g. 04xx xxx xxx"
                keyboardType="phone-pad"
                value={contactPhone}
                onChangeText={setContactPhone}
              />
            </View>
          </DetailSection>
        </ScrollView>

        <SafeAreaView edges={['bottom']} style={styles.footer}>
          <Pressable style={styles.submitButton} onPress={handleSubmit}>
            <Text style={styles.submitText}>Submit Request</Text>
          </Pressable>
        </SafeAreaView>
      </KeyboardAvoidingView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f7f9fb',
  },
  flex: {
    flex: 1,
  },
  header: {
    backgroundColor: colors.primary,
    paddingBottom: 16,
  },
  headerSafe: {
    paddingHorizontal: 20,
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
    marginTop: 8,
  },
  backButton: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: 'rgba(255,255,255,0.18)',
    alignItems: 'center',
    justifyContent: 'center',
  },
  headerTitle: {
    fontSize: 20,
    fontWeight: '700',
    color: colors.white,
    flex: 1,
  },
  body: {
    flex: 1,
  },
  bodyContent: {
    padding: 20,
    paddingBottom: 24,
  },
  form: {
    padding: 16,
    paddingBottom: 8,
  },
  footer: {
    backgroundColor: colors.white,
    borderTopWidth: 1,
    borderTopColor: colors.divider,
    paddingHorizontal: 20,
    paddingTop: 12,
    paddingBottom: 8,
  },
  submitButton: {
    backgroundColor: colors.primary,
    borderRadius: 14,
    minHeight: 54,
    alignItems: 'center',
    justifyContent: 'center',
    ...softShadow(colors.primary, 0.25),
  },
  submitText: {
    fontSize: 17,
    fontWeight: '700',
    color: colors.white,
  },
});
