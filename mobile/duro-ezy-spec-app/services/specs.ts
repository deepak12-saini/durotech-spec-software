import type { SpecStatus } from '../data/mockHome';
import type { Spec } from '../data/mockSpecs';
import { USE_MOCK_API } from '../constants/config';
import { getSpecById, mockSpecsList } from '../data/mockSpecs';
import { mockRecentSpecs, mockStats } from '../data/mockHome';
import { apiRequest } from './api';

export type SpecListItem = {
  id: string;
  trackNumber: string;
  project: string;
  client: string;
  status: SpecStatus;
  date: string;
};

export type SpecDetail = Spec;

export type SpecsMeta = {
  total: number;
  page: number;
  limit: number;
  stats?: {
    total: number;
    this_month: number;
    pending: number;
  };
};

type ApiSpecListItem = {
  id: number;
  track_number: string;
  project: string;
  client: string;
  status: SpecStatus;
  date: string;
};

type ApiSpecDetail = {
  id: number;
  track_number: string;
  project: string;
  project_full: string;
  client: string;
  address: string;
  email: string;
  spec_type: string;
  status: SpecStatus;
  date: string;
  has_pdf?: boolean;
};

type SpecsIndexResponse = {
  success: boolean;
  data: ApiSpecListItem[];
  meta: SpecsMeta;
};

type SpecViewResponse = {
  success: boolean;
  data: ApiSpecDetail;
};

type SpecPdfResponse = {
  success: boolean;
  url: string;
  filename: string;
};

function formatDisplayDate(isoDate: string): string {
  if (!isoDate) {
    return '';
  }

  const parsed = new Date(isoDate);
  if (Number.isNaN(parsed.getTime())) {
    return isoDate;
  }

  return parsed.toLocaleDateString('en-AU', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  });
}

function mapListItem(item: ApiSpecListItem): SpecListItem {
  return {
    id: String(item.id),
    trackNumber: item.track_number,
    project: item.project,
    client: item.client,
    status: item.status,
    date: formatDisplayDate(item.date),
  };
}

function mapDetail(item: ApiSpecDetail): SpecDetail {
  return {
    id: String(item.id),
    trackNumber: item.track_number,
    project: item.project,
    projectFull: item.project_full,
    client: item.client,
    address: item.address,
    email: item.email,
    specType: item.spec_type,
    status: item.status,
    date: formatDisplayDate(item.date),
  };
}

export async function fetchSpecs(params?: {
  search?: string;
  page?: number;
  limit?: number;
}): Promise<{ items: SpecListItem[]; meta: SpecsMeta }> {
  if (USE_MOCK_API) {
    const items = mockSpecsList.map((spec) => ({
      id: spec.id,
      trackNumber: spec.trackNumber,
      project: spec.project,
      client: spec.client,
      status: spec.status,
      date: spec.date,
    }));

    return {
      items,
      meta: {
        total: items.length,
        page: 1,
        limit: items.length,
        stats: {
          total: Number(mockStats[0]?.value ?? items.length),
          this_month: Number(mockStats[1]?.value ?? 0),
          pending: Number(mockStats[2]?.value ?? 0),
        },
      },
    };
  }

  const query = new URLSearchParams();
  if (params?.search) {
    query.set('search', params.search);
  }
  if (params?.page) {
    query.set('page', String(params.page));
  }
  if (params?.limit) {
    query.set('limit', String(params.limit));
  }

  const suffix = query.toString() ? `?${query.toString()}` : '';
  const response = await apiRequest<SpecsIndexResponse>(
    `/api/v1/specs.json${suffix}`,
  );

  return {
    items: response.data.map(mapListItem),
    meta: response.meta,
  };
}

export async function fetchSpecById(id: string): Promise<SpecDetail | null> {
  if (USE_MOCK_API) {
    return getSpecById(id) ?? null;
  }

  try {
    const response = await apiRequest<SpecViewResponse>(
      `/api/v1/specs/${id}.json`,
    );
    return mapDetail(response.data);
  } catch {
    return null;
  }
}

export async function fetchSpecPdf(
  id: string,
): Promise<{ url: string; filename: string } | null> {
  if (USE_MOCK_API) {
    const spec = getSpecById(id);
    if (!spec) {
      return null;
    }

    return {
      url: '',
      filename: `${spec.trackNumber.replace(/[^a-zA-Z0-9_-]/g, '_')}_Spec.pdf`,
    };
  }

  try {
    const response = await apiRequest<SpecPdfResponse>(
      `/api/v1/specs/${id}/pdf.json`,
    );
    return {
      url: response.url,
      filename: response.filename,
    };
  } catch {
    return null;
  }
}

export async function fetchHomeData(): Promise<{
  recentSpecs: SpecListItem[];
  stats: { value: string; label: string }[];
  total: number;
}> {
  const { items, meta } = await fetchSpecs({ page: 1, limit: 5 });

  if (USE_MOCK_API) {
    return {
      recentSpecs: mockRecentSpecs.map((spec) => ({
        id: spec.id,
        trackNumber: spec.trackNumber,
        project: spec.project,
        client: '',
        status: spec.status,
        date: '',
      })),
      stats: mockStats,
      total: items.length,
    };
  }

  const stats = meta.stats ?? {
    total: meta.total,
    this_month: 0,
    pending: 0,
  };

  return {
    recentSpecs: items.slice(0, 2),
    stats: [
      { value: String(stats.total), label: 'Total Specs' },
      { value: String(stats.this_month), label: 'This Month' },
      { value: String(stats.pending), label: 'Pending' },
    ],
    total: meta.total,
  };
}
