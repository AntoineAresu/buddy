export default class UrlBuilder {
  static buildUrl(url, params) {
    const urlObject = new URL(url);
    this.updateQueryParams(urlObject, params);

    return urlObject.toString();
  }

  static buildRoute(route, params) {
    const urlObject = new URL(route, window.location.origin);
    this.updateQueryParams(urlObject, params);

    return urlObject.pathname + urlObject.search
  }

  static updateQueryParams(urlObject, params) {
    Object.entries(params).forEach(([key, value]) => {
      urlObject.searchParams.set(key, value);
    });
  }
}
