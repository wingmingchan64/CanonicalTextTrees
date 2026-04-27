# Canonical Text Trees 基準正文樹

Status: Draft

---

## Overview

This repository stores **classical texts and related works as addressable text trees**, together with derived data such as coordinates and retrieval paths.

It is designed as a **text-source layer** for research and analysis systems, where texts are not merely read, but **referenced, aligned, and combined across sources**.

The repository now includes:

- Classical works (e.g. 《論語》, 《孟子》, 《文選》)
- Du Fu’s poetry (杜詩)
- Major commentarial works on Du Fu (杜著述), such as:
  - 林繼中輯校《杜詩趙次公先後解輯校》
  - 郭知達《新刊校定集注杜詩》
  - 仇兆鰲《杜詩詳註》
  - 蕭滌非《杜甫全集校注》

All of these are treated uniformly as **text sources with stable internal structure**.

---

## Design Principles

### Texts as Trees

Each work is converted into a **tree structure**, where:

- nodes represent structural units (段、行、句等)
- leaves contain textual content
- paths uniquely identify any retrievable unit

Granularity is determined by use:

- 杜詩正文: fine-grained (character-level when necessary)
- 典籍引用: segment / line-level by default
- 注本 / classical works: line-level by default

### Addressability

Every unit of text is addressable via a **path**, for example:

>`CHOUZHU,0006,5,13`

This allows:

- precise quotation
- retrieval of context
- cross-source alignment

Paths are stored in generated files such as `paths.json`.

### Separation of Concerns

This repository contains **texts and their structural representations only**.

It does not include:

- rendering logic
- application-specific metadata processing
- UI or display concerns

Those belong to external systems (e.g. Dufu-Analysis).

### Metadata-Free Text Storage

Texts are stored independently of annotation systems.

In downstream usage:

- metadata refers to texts by path
- texts are retrieved when needed
- no duplication of textual content inside metadata

### Context over Fragments

Many classical annotations quote only short fragments.

This repository enables:

- retrieval of full source passages
- reconstruction of textual context
- improved interpretability for modern readers

---

## Repository Structure

Each work is stored in its own directory:

<pre>
corpus/
  classical/
    論語/
      registry.json
      canonical_text/
      coordinates/
      metadata/
      raw_text/
      trees/
      views/
</pre>

Key folders
- `canonical_text/`<br />Normalized base text (source of truth)
- `trees/`
Generated tree representations
- `coordinates/`
Addressing systems for text units
metadata/
Optional, work-specific annotations (if applicable)
raw_text/
Input material (usually empty after processing)
views/
Generated sample outputs
registry.json
Describes the structure and configuration of the work

---

## Relationship to Other Projects

This repository serves as a text-source backend.

For example:

In Dufu-Analysis, metadata objects may contain paths like:

{
  "book": "郭",
  "src_path": "GUO,0003,5,13"
}
The analysis system retrieves the corresponding text from this repository

This allows:

multiple sources to be displayed together
quotations to be resolved to full context
comparison across editions and works

---

## Intended Use

This repository is intended for:

textual research
annotation systems
digital humanities workflows
personal study environments

It is not intended as a finished corpus, but as a growing, structured text base.

---

## Status

This project is ongoing.

Not all works are fully processed
Granularity may vary by text
Structures may evolve as needed

The focus is on:

building a stable, flexible system for working with texts

rather than completing all data.

---

## Summary

CanonicalTextTrees is:

a repository of structured, addressable texts that serve as a unified source layer for analysis, annotation, and contextual retrieval.