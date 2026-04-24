---
name: review-pr-comments
description: Review PR review comments and inline feedback, evaluate whether each is worth addressing, and recommend how to resolve valid ones. Re-runnable to catch new comments after previous ones are resolved.
allowed-tools: Bash(gh *) Read Grep Glob
---

Review all open PR comments on the current branch's pull request. For each comment, evaluate its merit and provide a clear recommendation.

## Steps

1. **Find the PR** for the current branch:
   ```
   gh pr list --head $(git branch --show-current)
   ```
   If no PR exists, stop and tell the user.

2. **Fetch all review comments** (inline code comments):
   ```
   gh api repos/{owner}/{repo}/pulls/{pr_number}/comments
   ```
   Extract the PR number from step 1. Determine `{owner}/{repo}` from:
   ```
   gh repo view --json nameWithOwner -q .nameWithOwner
   ```

3. **For each comment**, read the file at the referenced path to get full context around the commented line. Use the `Read` tool with an offset around `line` to see surrounding code.

4. **Evaluate each comment** and present your findings in this format:

---

### Comment on `{path}` line {line} — by {user}

> {comment body quoted verbatim}

**Verdict:** ✅ Worth addressing / ❌ Not worth addressing / ⚠️ Minor / already resolved

**Reasoning:** {1–3 sentences explaining why the feedback is or isn't valid, referencing the actual code}

**Recommendation:** {Specific, actionable description of the change to make — or why no change is needed. If already resolved, note that explicitly.}

---

5. **After all comments are reviewed**, provide a short summary:
   - Total comments reviewed
   - How many are worth addressing
   - Any patterns or themes across the feedback

## Important notes

- Read the actual code at the referenced file/line before evaluating — do not rely solely on the comment description
- If a comment references something that has already been fixed in the current working tree, mark it as **already resolved** and explain what the fix was
- This command is designed to be re-run after resolving some comments — always fetch fresh data from the GitHub API, never rely on prior conversation context
- Evaluate comments critically: not all automated or reviewer feedback is correct or appropriate for this project. Consider the project's CLAUDE.md conventions when judging validity
- If `$ARGUMENTS` is provided, treat it as a PR number to review instead of auto-detecting from the current branch
