
export default function StatCard({ title, value, description, icon, trend }) {
    return `
        <div class="bg-card rounded-lg border p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-muted-foreground font-medium">${title}</h3>
                    <div class="mt-1 flex items-baseline">
                        <p class="text-2xl font-semibold">${value}</p>
                        ${trend ? `
                            <p class="ml-2 text-xs flex items-center ${trend > 0 ? 'text-green-600' : 'text-red-600'}">
                                ${trend > 0 ? '↑' : '↓'} ${Math.abs(trend)}%
                            </p>
                        ` : ''}
                    </div>
                    ${description ? `<p class="mt-1 text-sm text-muted-foreground">${description}</p>` : ''}
                </div>
                <div class="rounded-full bg-primary/10 p-2 text-primary">
                    ${icon}
                </div>
            </div>
        </div>
    `;
}
