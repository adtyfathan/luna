import http from "k6/http";
import { check, sleep } from "k6";

export let options = {
    stages: [
        { duration: "1m", target: 25 },
        { duration: "1m", target: 50 },
        { duration: "1m", target: 100 },
        { duration: "1m", target: 250 },
        { duration: "1m", target: 0 },
    ],
};

// PUBLIC ROUTES ONLY
const BASE_URL = "http://127.0.0.1:8000";
const PUBLIC_ROUTES = [
    "/",
    "/edukasi",
    "/edukasi/1",
];

// TEST FLOW
export default function () {

    PUBLIC_ROUTES.forEach((route) => {
        let res = http.get(`${BASE_URL}${route}`);
        check(res, {
            [`GET ${route} 200`]: (r) => r.status === 200,
        });
    });

    sleep(0.1);
}
