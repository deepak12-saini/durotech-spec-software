import type { Spec } from './mockSpecs';

export const PDF_PAGE_COUNT = 8;

export function getPdfFilename(spec: Spec): string {
  return `${spec.trackNumber}_Spec.pdf`;
}

export function getMockPdfScopeText(spec: Spec): string {
  return `This specification covers the design and installation of ${spec.specType.toLowerCase()} systems for ${spec.projectFull}. All works shall be carried out in accordance with relevant Australian Standards and Durotech product data sheets.`;
}
