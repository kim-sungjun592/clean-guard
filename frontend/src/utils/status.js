export function getStatusInfo(temp, humidity, airQuality) {

    if (temp <= 5) {
        return {
            label: "🚨 동파 위험",
            level: "danger",
            bg: "bg-red-50 hover:bg-red-100",
            text: "text-red-700",
            border: "border-red-300"
        };
    }

    if (humidity >= 90) {
        return {
            label: "⚠ 누수 의심",
            level: "warning",
            bg: "bg-amber-50 hover:bg-amber-100",
            text: "text-amber-700",
            border: "border-amber-300"
        };
    }

    if (airQuality === "나쁨") {
        return {
            label: "⚠ 악취 발생",
            level: "warning",
            bg: "bg-amber-50 hover:bg-amber-100",
            text: "text-amber-700",
            border: "border-amber-300"
        };
    }

    return {
        label: "🟢 정상",
        level: "normal",
        bg: "bg-emerald-50 hover:bg-emerald-100",
        text: "text-emerald-700",
        border: "border-emerald-300"
    };

}

export function getOnlineStatus(createdAt) {

    if (!createdAt) {

        return {
            online: false,
            label: "🔴 Offline",
            color: "text-red-600"
        };

    }

    const last = new Date(createdAt.replace(" ", "T") + "Z");
    const now = new Date();

    const diff = (now - last) / 1000;

    if (diff <= 30) {

        return {
            online: true,
            label: "🟢 Online",
            color: "text-emerald-600"
        };

    }

    return {
        online: false,
        label: "🔴 Offline",
        color: "text-red-600"
    };

}

// Shared display metadata for a bare status level ("normal" | "warning" |
// "danger"), reusing the same color language as getStatusInfo(). Used by
// aggregate views (e.g. the building selector) that need to show a status
// without recomputing it from raw sensor values.
const LEVEL_META = {
    normal: {
        label: "🟢 정상",
        text: "text-emerald-700",
        bg: "bg-emerald-100",
        border: "border-emerald-300",
        dot: "bg-emerald-500"
    },
    warning: {
        label: "⚠ 경고",
        text: "text-amber-700",
        bg: "bg-amber-100",
        border: "border-amber-300",
        dot: "bg-amber-500"
    },
    danger: {
        label: "🚨 위험",
        text: "text-red-700",
        bg: "bg-red-100",
        border: "border-red-300",
        dot: "bg-red-500"
    }
};

export function getLevelMeta(level) {
    return LEVEL_META[level] ?? LEVEL_META.normal;
}