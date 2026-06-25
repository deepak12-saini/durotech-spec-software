import type { SpecStatus } from './mockHome';

export type Spec = {
  id: string;
  trackNumber: string;
  project: string;
  projectFull: string;
  client: string;
  address: string;
  email: string;
  specType: string;
  status: SpecStatus;
  date: string;
};

export const mockSpecsList: Spec[] = [
  {
    id: '1',
    trackNumber: 'DT-2024-0891',
    project: 'Riverside Commercial Tower',
    projectFull: 'Riverside Commercial Complex',
    client: 'Riverside Development Group',
    address: '42 Riverside Drive, Suite 1100, Melbourne VIC 3000',
    email: 'procurement@riversidev.com.au',
    specType: 'Below-Grade Waterproofing',
    status: 'Approved',
    date: 'Jun 18, 2024',
  },
  {
    id: '2',
    trackNumber: 'DT-2024-0874',
    project: 'Harbour View Apartments',
    projectFull: 'Harbour View Residential Complex',
    client: 'Coastal Living Pty Ltd',
    address: '18 Harbour Street, Sydney NSW 2000',
    email: 'projects@coastalliving.com.au',
    specType: 'Wet Area Waterproofing',
    status: 'Pending',
    date: 'Jun 15, 2024',
  },
  {
    id: '3',
    trackNumber: 'DT-2024-0856',
    project: 'Westfield Shopping Centre',
    projectFull: 'Westfield Shopping Centre Expansion',
    client: 'Scentre Group',
    address: '100 Oxford Street, Bondi Junction NSW 2022',
    email: 'specs@scentregroup.com',
    specType: 'Roof Waterproofing Membrane',
    status: 'Approved',
    date: 'Jun 12, 2024',
  },
  {
    id: '4',
    trackNumber: 'DT-2024-0832',
    project: 'Parkside Medical Centre',
    projectFull: 'Parkside Medical Centre Fit-out',
    client: 'HealthBuild Australia',
    address: '55 Park Road, Brisbane QLD 4000',
    email: 'tenders@healthbuild.com.au',
    specType: 'Internal Wet Area System',
    status: 'Draft',
    date: 'Jun 10, 2024',
  },
  {
    id: '5',
    trackNumber: 'DT-2024-0819',
    project: 'Lakeside Retirement Village',
    projectFull: 'Lakeside Retirement Village Stage 2',
    client: 'Aged Care Developments',
    address: '12 Lakeview Parade, Perth WA 6000',
    email: 'enquiries@agedcaredev.com.au',
    specType: 'External Liquid WPM',
    status: 'Pending',
    date: 'Jun 8, 2024',
  },
];

export function getSpecById(id: string): Spec | undefined {
  return mockSpecsList.find((spec) => spec.id === id);
}
