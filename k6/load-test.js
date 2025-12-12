import http from "k6/http";
import { check, sleep } from "k6";
import { htmlReport } from "https://raw.githubusercontent.com/benc-uk/k6-reporter/main/dist/bundle.js";

export let options = {
    stages: [
        { duration: "30s", target: 30 },
        { duration: "1m", target: 30 },
        { duration: "30s", target: 0 },
    ],
};

// PUBLIC ENDPOINTS
const BASE_URL = "http://127.0.0.1:8000";
const PUBLIC_ROUTES = [
    "/",
    "/edukasi",
    "/edukasi/1",
];

export function handleSummary(data) {
    return {
        "load-test.html": htmlReport(data),
    };
}

// TEST FLOW
export default function () {
    PUBLIC_ROUTES.forEach((route) => {
        let res = http.get(`${BASE_URL}${route}`);
        check(res, {
            [`GET ${route} 200`]: (r) => r.status === 200,
        });
        sleep(0.3);
    });

    sleep(1);
}
