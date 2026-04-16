import { useState, useEffect, useCallback } from 'react';
import { useTheme } from '../context/ThemeContext';

const API_CACHE = new Map();

/**
 * Generic fetch with caching
 */
async function cachedFetch(url, cacheKey) {
  if (API_CACHE.has(cacheKey)) {
    return API_CACHE.get(cacheKey);
  }
  const res = await fetch(url);
  if (!res.ok) throw new Error(`API error: ${res.status}`);
  const totalPages = parseInt(res.headers.get('X-WP-TotalPages') || '1', 10);
  const total = parseInt(res.headers.get('X-WP-Total') || '0', 10);
  const data = await res.json();
  const result = { data, totalPages, total };
  API_CACHE.set(cacheKey, result);
  return result;
}

/**
 * Hook: Fetch posts from WP REST API
 */
export function usePosts({ page = 1, perPage = 9, category = null, search = '', slug = '' } = {}) {
  const { restUrl } = useTheme();
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [totalPages, setTotalPages] = useState(1);
  const [total, setTotal] = useState(0);

  useEffect(() => {
    setLoading(true);
    let url = `${restUrl}/posts?_embed&per_page=${perPage}&page=${page}`;
    if (category) url += `&categories=${category}`;
    if (search) url += `&search=${encodeURIComponent(search)}`;
    if (slug) url += `&slug=${encodeURIComponent(slug)}`;
    const cacheKey = url;

    cachedFetch(url, cacheKey)
      .then(result => {
        setPosts(result.data);
        setTotalPages(result.totalPages);
        setTotal(result.total);
      })
      .catch(() => {
        setPosts([]);
        setTotalPages(1);
      })
      .finally(() => setLoading(false));
  }, [restUrl, page, perPage, category, search, slug]);

  return { posts, loading, totalPages, total };
}

/**
 * Hook: Fetch a single post by slug
 */
export function usePost(slug) {
  const { posts, loading } = usePosts({ slug, perPage: 1 });
  return { post: posts[0] || null, loading };
}

/**
 * Hook: Fetch pages
 */
export function usePages({ slug = '', perPage = 10 } = {}) {
  const { restUrl } = useTheme();
  const [pages, setPages] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    setLoading(true);
    let url = `${restUrl}/pages?_embed&per_page=${perPage}`;
    if (slug) url += `&slug=${encodeURIComponent(slug)}`;

    cachedFetch(url, url)
      .then(result => setPages(result.data))
      .catch(() => setPages([]))
      .finally(() => setLoading(false));
  }, [restUrl, slug, perPage]);

  return { pages, page: pages[0] || null, loading };
}

/**
 * Hook: Fetch categories
 */
export function useCategories() {
  const { restUrl } = useTheme();
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const url = `${restUrl}/categories?per_page=50&hide_empty=true`;
    cachedFetch(url, url)
      .then(result => setCategories(result.data))
      .catch(() => setCategories([]))
      .finally(() => setLoading(false));
  }, [restUrl]);

  return { categories, loading };
}

/**
 * Hook: Fetch tags
 */
export function useTags() {
  const { restUrl } = useTheme();
  const [tags, setTags] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const url = `${restUrl}/tags?per_page=50&hide_empty=true`;
    cachedFetch(url, url)
      .then(result => setTags(result.data))
      .catch(() => setTags([]))
      .finally(() => setLoading(false));
  }, [restUrl]);

  return { tags, loading };
}

/**
 * Hook: Fetch comments for a post
 */
export function useComments(postId) {
  const { restUrl } = useTheme();
  const [comments, setComments] = useState([]);
  const [loading, setLoading] = useState(true);

  const refresh = useCallback(() => {
    if (!postId) return;
    setLoading(true);
    const url = `${restUrl}/comments?post=${postId}&per_page=50&orderby=date_gmt&order=asc`;
    // Bypass cache for refresh
    fetch(url)
      .then(r => r.json())
      .then(data => setComments(Array.isArray(data) ? data : []))
      .catch(() => setComments([]))
      .finally(() => setLoading(false));
  }, [restUrl, postId]);

  useEffect(() => { refresh(); }, [refresh]);

  return { comments, loading, refresh };
}

/**
 * Submit a comment
 */
export function useSubmitComment() {
  const { restUrl, nonce } = useTheme();
  const [submitting, setSubmitting] = useState(false);

  const submit = async ({ postId, author, email, content, parent = 0 }) => {
    setSubmitting(true);
    try {
      const res = await fetch(`${restUrl}/comments`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          ...(nonce ? { 'X-WP-Nonce': nonce } : {}),
        },
        body: JSON.stringify({
          post: postId,
          author_name: author,
          author_email: email,
          content,
          parent,
        }),
      });
      if (!res.ok) throw new Error('Failed to submit');
      return await res.json();
    } finally {
      setSubmitting(false);
    }
  };

  return { submit, submitting };
}

/**
 * Extract featured image URL from _embedded
 */
export function getFeaturedImage(post, size = 'medium_large') {
  try {
    const media = post._embedded?.['wp:featuredmedia']?.[0];
    if (!media) return null;
    return media.media_details?.sizes?.[size]?.source_url || media.source_url || null;
  } catch {
    return null;
  }
}

/**
 * Extract categories from _embedded
 */
export function getCategories(post) {
  try {
    return post._embedded?.['wp:term']?.[0] || [];
  } catch {
    return [];
  }
}

/**
 * Extract tags from _embedded
 */
export function getTags(post) {
  try {
    return post._embedded?.['wp:term']?.[1] || [];
  } catch {
    return [];
  }
}

/**
 * Strip HTML tags from string
 */
export function stripHtml(html) {
  const tmp = document.createElement('div');
  tmp.innerHTML = html;
  return tmp.textContent || tmp.innerText || '';
}

/**
 * Truncate excerpt
 */
export function truncate(str, words = 20) {
  const clean = stripHtml(str);
  const arr = clean.split(/\s+/);
  return arr.length > words ? arr.slice(0, words).join(' ') + '…' : clean;
}
