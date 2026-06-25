export const mockUser = {
  greeting: 'Good morning,',
  name: 'James Harrington',
  initials: 'JH',
  role: 'Senior Specification Manager',
  email: 'j.harrington@durotech.com.au',
};

export const mockStats = [
  { value: '47', label: 'Total Specs' },
  { value: '12', label: 'This Month' },
  { value: '3', label: 'Pending' },
];

export type SpecStatus = 'Approved' | 'Pending' | 'Draft';

export type RecentSpec = {
  id: string;
  trackNumber: string;
  project: string;
  status: SpecStatus;
};

export const mockRecentSpecs: RecentSpec[] = [
  {
    id: '1',
    trackNumber: 'DT-2024-0891',
    project: 'Riverside Com...',
    status: 'Approved',
  },
  {
    id: '2',
    trackNumber: 'DT-2024-0874',
    project: 'Under review...',
    status: 'Pending',
  },
];
