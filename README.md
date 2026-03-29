# CommunicationFoundation Plugin

The **CommunicationFoundation Plugin** provides the foundational contract and model layer for all BASE3 components related to outbound communication, content publishing, and platform-neutral delivery workflows.

It defines a clean, reusable set of interfaces, default models, and base exceptions that act as stable contracts between framework components and provider-specific integrations. This keeps communication-related plugins modular, predictable, and easy to extend.

---

## Purpose

Whenever content is published to external platforms, a strict separation between **generic contracts** and **provider-specific implementations** is essential.

The CommunicationFoundation Plugin exists to provide exactly this shared foundation:

* Central place for all **interfaces** related to outbound publishing
* Reusable **default models** for generic communication payloads
* Common **base exceptions** for validation and publishing errors
* Stable **contracts** for platform-specific integrations such as Tumblr and future providers
* Clear separation between **content**, **delivery metadata**, and **publication result**

By moving these concerns into a dedicated foundation plugin, provider implementations can stay focused on API integration and transport logic without redefining the core model each time.

---

## Scope

This plugin contains the **foundation layer** for communication in BASE3.

It does **not** contain platform-specific API clients, concrete provider integrations, UI components, or transport implementations. Instead, it defines the reusable building blocks required by such plugins.

The scope includes:

* **Posts** – generic content objects containing title, caption, link, tags, media, and language
* **Media** – structured media attachments such as images or videos
* **Publish Requests** – delivery-specific metadata such as target, scheduling, reply references, visibility, and provider-specific options
* **Publishers** – service contracts for publishing content to external providers
* **Publish Results** – normalized result contracts for success state, identifiers, URLs, timestamps, error messages, and provider response data
* **Models** – immutable default implementations of the core contracts
* **Exceptions** – shared exception types for validation failures and publishing errors

This design allows communication-related plugins to stay generic at the contract level while supporting very different provider implementations.

---

## Core Design Idea

The central design principle of the CommunicationFoundation Plugin is the separation of **content** from **delivery**.

The responsibilities are split as follows:

* `ICommunicationPost` describes the actual content
* `ICommunicationPostMedia` describes attached media assets
* `ICommunicationPublishRequest` describes where, when, and how the content should be published
* `ICommunicationPublisher` performs the publication against a concrete provider
* `ICommunicationPublishResult` returns the normalized result of the publication attempt

This separation allows the same content model to be reused across multiple platforms and delivery scenarios.

A single post can therefore be wrapped into different publish requests and sent to different targets without changing the content object itself.

---

## Supported Use Cases

The contracts are intentionally platform-neutral and designed to support a wide range of communication targets, including for example:

* Tumblr
* Mastodon
* Facebook
* LinkedIn
* Pinterest
* Internal publishing systems
* Content syndication services
* Automation and agent-driven publication workflows

The plugin does not assume a specific provider model and therefore remains reusable across many kinds of outbound communication scenarios.

---

## Key Interfaces

### `ICommunicationPost`

Represents the publishable content itself.

Typical properties include:

* Title
* Caption text
* Link
* Tags
* Media attachments
* Language

This interface models only the content and intentionally excludes any delivery-specific information.

### `ICommunicationPostMedia`

Represents a single media attachment associated with a post.

Typical properties include:

* Source path or URL
* Logical media type such as `image` or `video`
* MIME type
* Title
* Alt text
* Sort order
* Optional thumbnail source

This allows publishers to handle multiple media assets in a structured and extensible way.

### `ICommunicationPublishRequest`

Wraps a post together with delivery-specific metadata.

Typical properties include:

* The post object itself
* Target account, blog, page, profile, or channel
* Planned publish date
* Visibility
* Reply or parent post reference
* Provider-specific options

This separation is important because identical content may be published to different destinations or under different delivery conditions.

### `ICommunicationPublisher`

Defines the contract for services that publish content to an external platform.

A provider-specific plugin such as a Tumblr plugin can implement this interface and translate the generic request into the provider’s native API calls.

### `ICommunicationPublishResult`

Provides a normalized result after publishing.

Typical properties include:

* Success state
* External post identifier
* External URL
* Publication timestamp
* Error message
* Raw normalized provider response data

This makes logging, debugging, synchronization, and downstream processing more consistent across providers.

---

## Default Models

In addition to the interfaces, the plugin provides reusable default model implementations.

These models are intended to be the standard immutable data objects used by higher-level services and provider implementations unless a project requires specialized variants.

The following models are included:

* `CommunicationPost`
* `CommunicationPostMedia`
* `CommunicationPublishRequest`
* `CommunicationPublishResult`

These classes implement the corresponding interfaces and provide a stable default data layer for communication workflows.

---

## Exception Hierarchy

The plugin also provides a small shared exception hierarchy for communication-related errors.

### `CommunicationException`

Base exception for all communication-related runtime errors inside the plugin and provider integrations.

### `CommunicationValidationException`

Used when a communication model receives structurally invalid input data, such as invalid array contents or malformed option maps.

### `CommunicationPublishException`

Used when a concrete publisher fails during publication, for example because of provider API errors, upload failures, authentication problems, or rejected requests.

This exception may also carry normalized diagnostic context data for logging and debugging.

---

## Integration

The CommunicationFoundation Plugin is designed to be used by other BASE3 plugins and services that need a shared communication contract layer.

Typical consumers include:

* **Tumblr** integrations
* Future **social media** plugins
* Internal **content syndication** services
* Publishing automation
* Agent-based systems that generate and publish content
* Workflow or queue-based communication pipelines

By depending only on the contracts and default models in CommunicationFoundation, these components remain decoupled from each other and from any single provider implementation.

---

## Benefits

* **Clear contracts**  
  Every publisher knows exactly which input it receives and which result it must return.

* **Platform neutrality**  
  The same core content model can be reused across multiple communication providers.

* **Separation of concerns**  
  Content, delivery metadata, publication logic, and result handling are clearly separated.

* **Extensibility**  
  New providers can be added without changing the shared contract layer.

* **Reusability**  
  Interfaces, models, and exceptions can be reused across plugins and projects.

* **Maintainability**  
  A stable foundation reduces duplication and keeps provider-specific code focused.

* **Future-proofing**  
  New communication targets and features can be integrated with minimal refactoring.

---

## Example Structure

```text
CommunicationFoundation/
 └─ src/
     ├─ Api/
     │   ├─ ICommunicationPost.php
     │   ├─ ICommunicationPostMedia.php
     │   ├─ ICommunicationPublishRequest.php
     │   ├─ ICommunicationPublisher.php
     │   └─ ICommunicationPublishResult.php
     ├─ Model/
     │   ├─ CommunicationPost.php
     │   ├─ CommunicationPostMedia.php
     │   ├─ CommunicationPublishRequest.php
     │   └─ CommunicationPublishResult.php
     └─ Exception/
         ├─ CommunicationException.php
         ├─ CommunicationValidationException.php
         └─ CommunicationPublishException.php
