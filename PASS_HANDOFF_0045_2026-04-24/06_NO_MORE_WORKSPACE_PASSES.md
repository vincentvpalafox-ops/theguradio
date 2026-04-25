# No More Workspace-Only Passes

This pass sets the terminal rule for the current scope:

- do not generate further workspace-only continuation passes for the homepage preview proof path unless the external blocker changes

Reason:

- the project is not blocked on local code
- the project is not blocked on local tooling
- the project is not blocked on route health
- the project is not blocked on proof bundle integrity
- the project is blocked only on a legitimate authenticated hosting session

Therefore:

- repeated continuation requests without restored hosting access should not create more development-pass artifacts
- the next meaningful action must be external to this workspace

That action is:

- reauthenticate to the hosting surface
- then execute the prepared preview proof bundle
