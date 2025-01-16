const BASE_COLLECTION_URL = '/collections';

const urls = {
    collections: {
        createForm: `${BASE_COLLECTION_URL}/create-form`,
        editForm: (id) => `${BASE_COLLECTION_URL}/${id}/edit-form`,
        create: BASE_COLLECTION_URL,
        update: (id) => `${BASE_COLLECTION_URL}/${id}`,
        createWithPainting: `${BASE_COLLECTION_URL}/create-with-painting`,
        delete: (id) => `${BASE_COLLECTION_URL}/${id}`,
        restore: (id) => `${BASE_COLLECTION_URL}/${id}/restore`,
    },
};

export default urls;