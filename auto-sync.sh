#!/bin/bash
# Auto-sync script for Bublemart project

echo "🚀 Starting auto-sync for Bublemart project..."

# Function to sync changes
sync_changes() {
    echo "📝 Detected changes, syncing to Git..."
    
    # Add all changes
    git add .
    
    # Commit with timestamp
    timestamp=$(date "+%Y-%m-%d %H:%M:%S")
    git commit -m "Auto-sync: $timestamp"
    
    # Push to remote
    current_branch=$(git branch --show-current)
    git push origin $current_branch
    
    if [ $? -eq 0 ]; then
        echo "✅ Successfully synced at $timestamp"
    else
        echo "❌ Failed to sync at $timestamp"
    fi
}

# Watch for file changes (requires fswatch)
if command -v fswatch &> /dev/null; then
    echo "👀 Watching for file changes..."
    fswatch -o . | while read f; do
        sync_changes
    done
else
    echo "⚠️  fswatch not found. Install it with: brew install fswatch"
    echo "📋 Manual sync commands:"
    echo "   git add ."
    echo "   git commit -m 'Your message'"
    echo "   git push origin main"
fi 