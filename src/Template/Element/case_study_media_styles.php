<style>
.case-media-section {
    margin-top: 2rem;
    margin-bottom: 2rem;
    padding: 1.75rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
}
.case-media-section__title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.35rem;
}
.case-media-section__subtitle {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}
.case-upload-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}
@media (max-width: 768px) {
    .case-upload-grid { grid-template-columns: 1fr; }
}
.case-upload-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 1.25rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.case-upload-card:hover { border-color: #94a3b8; }
.case-upload-card--full { grid-column: 1 / -1; }
.case-upload-card__label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}
.case-upload-card__badge {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
}
.case-upload-card__badge--before { background: #fef3c7; color: #92400e; }
.case-upload-card__badge--after { background: #d1fae5; color: #065f46; }
.case-upload-card__badge--featured { background: #dbeafe; color: #1e40af; }
.case-upload-card__badge--pdf { background: #fce7f3; color: #9d174d; }
.case-upload-card__badge--gallery { background: #ede9fe; color: #5b21b6; }
.case-gallery-card { margin-top: 1.25rem; }
.case-gallery-card__hint { font-size: 0.875rem; margin-bottom: 0.75rem; }
.case-upload-zone--gallery { min-height: 100px; }
.case-gallery-file-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.existing-images-gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 0.5rem;
    padding: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    max-height: 320px;
    overflow-y: auto;
}
.existing-images-gallery .image-card {
    flex: 0 0 auto;
    width: 140px;
    position: relative;
}
.existing-images-gallery .image-card img {
    width: 100%;
    height: 110px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #ddd;
    display: block;
}
.case-upload-zone {
    position: relative;
    border: 2px dashed #cbd5e1;
    border-radius: 8px;
    padding: 1.5rem 1rem;
    text-align: center;
    cursor: pointer;
    background: #fafbfc;
    transition: border-color 0.2s, background 0.2s;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
.case-upload-zone:hover,
.case-upload-zone.is-dragover,
.case-upload-zone.has-file {
    border-color: #3b82f6;
    background: #eff6ff;
}
.case-upload-zone.has-file .case-upload-zone__icon { color: #3b82f6; }
.case-upload-zone__icon { font-size: 1.75rem; color: #94a3b8; }
.case-upload-zone__text { font-size: 0.875rem; color: #64748b; margin: 0; }
.case-upload-zone__filename {
    font-size: 0.8rem;
    color: #3b82f6;
    font-weight: 600;
    word-break: break-all;
    max-width: 100%;
}
.case-upload-zone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.case-upload-preview {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}
.case-upload-preview__label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}
.case-upload-preview__img-wrap {
    position: relative;
    display: inline-block;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.case-upload-preview__img-wrap img {
    display: block;
    max-width: 100%;
    max-height: 180px;
    object-fit: contain;
    background: #f1f5f9;
}
.case-upload-preview__delete {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    z-index: 2;
}
.case-upload-preview__file-wrap {
    position: relative;
    display: inline-block;
    padding-top: 0.25rem;
    padding-right: 2.5rem;
}
.case-upload-preview__new { margin-top: 0.75rem; }
.case-upload-preview__new img {
    max-height: 120px;
    border-radius: 6px;
    border: 2px solid #3b82f6;
}
.case-status-row {
    margin-top: 1.5rem;
    padding: 1rem 1.25rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}
</style>
