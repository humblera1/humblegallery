const BASE_AUTH_URL = '/auth';
const BASE_PAINTINGS_URL = '/paintings';
const BASE_COLLECTION_URL = '/collections';

const urls = {
    auth: {
        login: `${BASE_AUTH_URL}/login`,
    },

    paintings: {
        toggleLike: (id) => `${BASE_PAINTINGS_URL}/${id}/toggle-like`
    },

    collections: {
        createForm: `${BASE_COLLECTION_URL}/create-form`,
        editForm: (id) => `${BASE_COLLECTION_URL}/${id}/edit-form`,
        withPaintingForm: (paintingId) => `${BASE_COLLECTION_URL}/with-painting-form/${paintingId}`,
        availableCollections: (paintingId) => `${BASE_COLLECTION_URL}/available-collections/${paintingId}`,
        create: BASE_COLLECTION_URL,
        update: (id) => `${BASE_COLLECTION_URL}/${id}/update`,
        togglePainting: (id, paintingId) => `${BASE_COLLECTION_URL}/${id}/toggle-painting/${paintingId}`,
        delete: (id) => `${BASE_COLLECTION_URL}/${id}`,
        restore: (id) => `${BASE_COLLECTION_URL}/${id}/restore`,
    },
};

export default urls;