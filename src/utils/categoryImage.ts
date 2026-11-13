import eventsPlanningImage from "../assets/events-planning.png";

export function getCategoryImage(
  name: string,
  fallback: string | null,
): string | null {
  return name.toLowerCase().includes("event") ? eventsPlanningImage : fallback;
}
