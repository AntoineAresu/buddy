export default class CalendarHelper {
    static formatNightsEvents(nights) {
        return nights.map(night => ({
            start: night.end,
            title: `🌙 Nuit du ${CalendarHelper.getDayOfMonth(night.start)} au ${CalendarHelper.getDayOfMonth(night.end)} : ${night.duration}h`,
            allDay: true,
            backgroundColor: '#B8CDE0',
            borderColor: '#9BBFD4',
            textColor: '#1e272e',
        }));
    }

    static formatCrossingsEvents(crossings) {
        return crossings.flatMap(({ date, reactionCount, noReactionCount }) => {
            const events = [];
            if (reactionCount > 0) events.push({
                start: date,
                title: `🐶 ${reactionCount}`,
                allDay: true,
                backgroundColor: '#C17A68',
                borderColor: '#C17A68',
                textColor: '#fff',
            });
            if (noReactionCount > 0) events.push({
                start: date,
                title: `🐶 ${noReactionCount}`,
                allDay: true,
                backgroundColor: '#7FA58A',
                borderColor: '#7FA58A',
                textColor: '#fff',
            });
            return events;
        });
    }

    static getDayOfMonth(date) {
        return new Date(date).getDate();
    }
}
