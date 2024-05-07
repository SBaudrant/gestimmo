import axios, { Method } from 'axios';

//TODO Maybe change this to get endpoint from a config file instead
const API_ENDPOINT = process.env.REACT_APP_API_ENDPOINT || 'http://localhost:8000';

export async function callApi(method: Method, url: string, data?: any) {
  return axios.request({
    method,
    baseURL: API_ENDPOINT,
    headers: {
      Accept: 'application/json'
    },
    url,
    data,
  });
}
